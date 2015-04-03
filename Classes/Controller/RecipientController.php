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
 * RecipientController
 */
class RecipientController extends BaseController {

	/**
	 * action subscribe
	 *
	 * @param \LEO\NewsletterMan\Domain\Model\Recipient $recipient
	 * @return void
	 */
	public function subscribeAction(\LEO\NewsletterMan\Domain\Model\Recipient $recipient = null) {
		$this->view->assign('gender', $this->getGenderArray());
		$this->view->assign('recipient', $recipient);

		if ($this->request->hasArgument('exists')) {
			$this->view->assign('exists', $this->request->getArgument('exists'));
		}
	}

	/**
	 * action save
	 *
	 * @param \LEO\NewsletterMan\Domain\Model\Recipient $recipient
	 * @return void
	 */
	public function saveAction(\LEO\NewsletterMan\Domain\Model\Recipient $recipient) {
		$recipientExists = $this->recipientExists($recipient);

		if ($recipientExists === 'new') {
			$recipient->setHash();
			$recipient->setHidden(1);
			$recipient->setPid($this->settings['storagePid']);

			$this->recipientRepository->add($recipient);
			$this->initializeMail($recipient);

			$this->redirect(null, null, null, null, $this->settings['redirect']);
		} else {
			if ($recipientExists == 'deleted') {
				$recipient->setHash();
				$recipient->setHidden(1);
				$recipient->setDeleted(0);

				$this->recipientRepository->update($recipient);
				$this->initializeMail($recipient);

				$this->redirect(null, null, null, null, $this->settings['redirect']);
			} else {
				$updateRecipient = $this->recipientRepository->findOnlyByMail($recipient->getEmail())->current();
				$this->forward('subscribe', 'Recipient', null, array('recipient' => $updateRecipient, 'exists' => $recipientExists));
			}
		}
	}

	/**
	 * action unsubscribe
	 *
	 * @return void
	 */
	public function unsubscribeAction() {
	}

	/**
	 * action save
	 *
	 * @param \LEO\NewsletterMan\Domain\Model\Recipient $recipient
	 * @return void
	 */
	public function deleteAction(\LEO\NewsletterMan\Domain\Model\Recipient $recipient) {
		$recipientToDelete = $this->recipientRepository->findByMail($recipient->getEmail());

		$this->view->assign('recipientToDelete', $recipientToDelete);
		$this->view->assign('recipient', $recipient);

		if ($this->request->hasArgument('DELETE')) {
			$this->recipientRepository->remove($recipientToDelete);
			$this->redirect(null, null, null, null, $this->settings['redirect']);
		}
	}

	/**
	 * action actmail
	 * re-send confirmation mail
	 *
	 * @param integer $recipientUid
	 * @return void
	 */
	public function actmailAction($recipientUid) {
		$recipient = $this->recipientRepository->findInactive($recipientUid);

		$this->initializeMail($recipient);
		$this->redirect(null, null, null, null, $this->settings['redirect']);
	}

	/**
	 * action done
	 *
	 * @return void
	 */
	public function doneAction() {
	}

	/**
	 * action confirm
	 *
	 * @param string $hash
	 * @return void
	 */
	public function confirmAction($hash) {
		$recipient = $this->recipientRepository->findByHash($hash);

		if ($recipient != null) {
			$recipient->setHidden(0);
			$this->recipientRepository->update($recipient);
		}

		$this->view->assign('recipient', $recipient);
	}
}
