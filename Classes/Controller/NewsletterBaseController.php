<?php
namespace LEO\NewsletterMan\Controller;


/***************************************************************
 *
 *  Copyright notice
 *
 *  (c) 2015 Marc Scherer <mail@loewenstall.de>, LÖWENSTALL
 *
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 3 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/

/**
 * NewsletterBaseController
 */
class NewsletterBaseController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController {

	/**
	 * recipientRepository
	 *
	 * @var \LEO\NewsletterMan\Domain\Repository\RecipientRepository
	 * @inject
	 */
	protected $recipientRepository = NULL;

	/**
	 * newsletterRepository
	 *
	 * @var \LEO\NewsletterMan\Domain\Repository\NewsletterRepository
	 * @inject
	 */
	protected $newsletterRepository = NULL;

	/**
	 * @var array
	 */
	protected $pluginSettings = array();

	/**
	 * @var string
	 */
	protected $subject = '';

	/**
	 * @var array
	 */
	protected $sender = array();

	/**
	 * @var string
	 */
	protected $newsletterContent = '';

	public function initializeAction() {
		$this->pluginSettings = unserialize($GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['newsletter_man']);
	}

	/**
	 * @param \LEO\NewsletterMan\Domain\Model\Newsletter $newsletter
	 */
	protected function initializeMailer(\LEO\NewsletterMan\Domain\Model\Newsletter $newsletter) {
		$this->newsletterContent = $this->getNewsletterHtml($newsletter);
		$this->subject = $newsletter->getTitle();
		$this->sender = array($newsletter->getSender()->getSenderMail() => $newsletter->getSender()->getSenderName());

		$this->startMailSpooler($newsletter);
	}

	/**
	 * @param \LEO\NewsletterMan\Domain\Model\Newsletter $newsletter
	 */
	protected function startMailSpooler(\LEO\NewsletterMan\Domain\Model\Newsletter $newsletter) {
		$sent = 1;

		foreach ($this->getRecipientsArray($newsletter->getRecipients()) as $recipient) {
			$mailRecipient = array($recipient->getEmail() => $recipient->getFirstName() . ' ' . $recipient->getLastName());
			$this->sendNewsletter($mailRecipient, $this->sender, $this->subject);

			$sent++;

			$sendPerCycle = (!isset($this->pluginSettings['sendPerCycle'])) ? 50 : $this->pluginSettings['sendPerCycle'];

			if ($sent == $sendPerCycle) {
				sleep(5);
			}
		}

		$newsletter->setState(1);
	}

	/**
	 * @param object $recipientsObj
	 * @return array
	 */
	protected function getRecipientsArray($recipientsObj) {
		$recipients = array();

		foreach ($recipientsObj->toArray() as $recipientList) {
			foreach ($recipientList->getRecipients() as $recipient) {
				$recipients = $this->recipientRepository->findByPid($recipient->getUid());
			}
		}

		return $recipients;
	}

	/**
     * @param array $recipient recipient of the email in the format array('recipient@domain.tld' => 'Recipient Name')
     * @param array $sender sender of the email in the format array('sender@domain.tld' => 'Sender Name')
     * @param string $subject subject of the email
     * @return boolean TRUE on success, otherwise false
     */
    protected function sendNewsletter(array $recipient, array $sender, $subject) {
        /** @var $message \TYPO3\CMS\Core\Mail\MailMessage */
        $message = $this->objectManager->get('TYPO3\\CMS\\Core\\Mail\\MailMessage');
        $message->setTo($recipient)
                ->setFrom($sender)
                ->setSubject($subject);

        $message->setBody($this->newsletterContent, 'text/html');

        $message->send();

        return $message->isSent();
    }

	protected function log() {
	}

	/**
	 * @param \LEO\NewsletterMan\Domain\Model\Newsletter $newsletter
	 * @return mixed
	 */
	protected function getNewsletterHtml(\LEO\NewsletterMan\Domain\Model\Newsletter $newsletter) {
		$url = $this->settings['baseURL'] . 'index.php?id=' . $newsletter->getPage();

		return \TYPO3\CMS\Core\Utility\GeneralUtility::getURL($url);
	}

	protected function debug($content, $die) {
		echo '<pre>';
		var_dump($content);
		echo '</pre>';

		if ($die) die;
	}
}
