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
 * BaseController
 */
class BaseController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController {

	/**
	 * recipientRepository
	 *
	 * @var \LEO\NewsletterMan\Domain\Repository\RecipientRepository
	 * @inject
	 */
	protected $recipientRepository = NULL;

	/**
	 * @var array
	 */
	protected $gender = array();

	public function initializeAction() {
		$this->gender = $this->getGenderArray();
	}

	/**
	 * action list
	 *
	 * @return array
	 */
	protected function getGenderArray() {
		return array(
			'none' => $this->translate('gender.none'),
			'mrs' => $this->translate('gender.mrs'),
			'mr' => $this->translate('gender.mr')
		);
	}

	/**
	 * @param string $key
	 * @return string
	 */
	protected function translate($key) {
		return \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate($key, 'newsletter_man');
	}

	/**
	 * @param \LEO\NewsletterMan\Domain\Model\Recipient $recipient
	 * @return string
	 */
	protected function recipientExists(\LEO\NewsletterMan\Domain\Model\Recipient $recipient) {
		$checkForRecipient = $this->recipientRepository->findOnlyByMail($recipient->getEmail());

		if ($checkForRecipient->count() == 0) {
			return 'new';
		} else {
			if ($checkForRecipient->current()->getHidden() == 1) {
				return 'notConfirmed';
			}

			if ($checkForRecipient->current()->getDeleted() == 1) {
				return 'deleted';
			}

			if ($checkForRecipient->current()->getHidden() == 0 && $checkForRecipient->current()->getDeleted() == 0) {
				return 'active';
			}
		}
	}

	/**
	 * @param \LEO\NewsletterMan\Domain\Model\Recipient $recipient
	 */
	protected function initializeMail(\LEO\NewsletterMan\Domain\Model\Recipient $recipient) {
		$mailRecipient = array($recipient->getEmail() => $recipient->getFirstName() . ' ' . $recipient->getLastName());
		$sender = array($this->settings['senderEmail'] => $this->settings['senderName']);
		$subject = $this->settings['subject'];
		$view = array(
			'text' => $this->settings['text'],
			'footer' => $this->settings['footer'],
			'recipient' => $recipient
		);

		$this->sendConfirmationMail($mailRecipient, $sender, $subject, $view);
		unset($view);
	}

	/**
     * @param array $recipient recipient of the email in the format array('recipient@domain.tld' => 'Recipient Name')
     * @param array $sender sender of the email in the format array('sender@domain.tld' => 'Sender Name')
     * @param string $subject subject of the email
     * @param array $view variables to be passed to the Fluid view
     * @return boolean TRUE on success, otherwise false
     */
    protected function sendConfirmationMail(array $recipient, array $sender, $subject, array $view = array()) {
        $emailView = $this->objectManager->get('TYPO3\\CMS\\Fluid\\View\\StandaloneView');
        $extbaseFrameworkConfiguration = $this->configurationManager->getConfiguration(\TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface::CONFIGURATION_TYPE_FRAMEWORK);
        $templateRootPath = \TYPO3\CMS\Core\Utility\GeneralUtility::getFileAbsFileName($extbaseFrameworkConfiguration['view']['templateRootPath']);
        $templatePathAndFilename = $templateRootPath . 'Email/OptIn.html';

		$emailView->setTemplatePathAndFilename($templatePathAndFilename);
        $emailView->assignMultiple($view);

        $emailBody = $emailView->render();

        /** @var $message \TYPO3\CMS\Core\Mail\MailMessage */
        $message = $this->objectManager->get('TYPO3\\CMS\\Core\\Mail\\MailMessage');
        $message->setTo($recipient)
                ->setFrom($sender)
                ->setSubject($subject);

        $message->setBody($emailBody, 'text/plain');

        $message->send();

        return $message->isSent();
    }
}
