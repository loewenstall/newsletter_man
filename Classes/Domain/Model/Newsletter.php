<?php
namespace LEO\NewsletterMan\Domain\Model;


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
 * Create a newsletter
 */
class Newsletter extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity {

	/**
	 * sendDate
	 *
	 * @var \DateTime
	 */
	protected $sendDate = NULL;

	/**
	 * page
	 *
	 * @var integer
	 */
	protected $page = 0;

	/**
	 * state
	 *
	 * @var integer
	 */
	protected $state = 0;

	/**
	 * Recipient list
	 *
	 * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\LEO\NewsletterMan\Domain\Model\RecipientList>
	 * @cascade remove
	 */
	protected $recipients = NULL;

	/**
	 * The sender of this newsletter
	 *
	 * @var \LEO\NewsletterMan\Domain\Model\Sender
	 */
	protected $sender = NULL;

	/**
	 * __construct
	 */
	public function __construct() {
		//Do not remove the next line: It would break the functionality
		$this->initStorageObjects();
	}

	/**
	 * Initializes all ObjectStorage properties
	 * Do not modify this method!
	 * It will be rewritten on each save in the extension builder
	 * You may modify the constructor of this class instead
	 *
	 * @return void
	 */
	protected function initStorageObjects() {
		$this->recipients = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
	}

	/**
	 * Returns the sendDate
	 *
	 * @return \DateTime $sendDate
	 */
	public function getSendDate() {
		return $this->sendDate;
	}

	/**
	 * Sets the sendDate
	 *
	 * @param \DateTime $sendDate
	 * @return void
	 */
	public function setSendDate(\DateTime $sendDate) {
		$this->sendDate = $sendDate;
	}

	/**
	 * Returns the page
	 *
	 * @return integer $page
	 */
	public function getPage() {
		return $this->page;
	}

	/**
	 * Sets the page
	 *
	 * @param integer $page
	 * @return void
	 */
	public function setPage($page) {
		$this->page = $page;
	}

	/**
	 * Returns the state
	 *
	 * @return integer $state
	 */
	public function getState() {
		return $this->state;
	}

	/**
	 * Sets the state
	 *
	 * @param integer $state
	 * @return void
	 */
	public function setState($state) {
		$this->state = $state;
	}

	/**
	 * Adds a RecipientList
	 *
	 * @param \LEO\NewsletterMan\Domain\Model\RecipientList $recipient
	 * @return void
	 */
	public function addRecipient(\LEO\NewsletterMan\Domain\Model\RecipientList $recipient) {
		$this->recipients->attach($recipient);
	}

	/**
	 * Removes a RecipientList
	 *
	 * @param \LEO\NewsletterMan\Domain\Model\RecipientList $recipientToRemove The RecipientList to be removed
	 * @return void
	 */
	public function removeRecipient(\LEO\NewsletterMan\Domain\Model\RecipientList $recipientToRemove) {
		$this->recipients->detach($recipientToRemove);
	}

	/**
	 * Returns the recipients
	 *
	 * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\LEO\NewsletterMan\Domain\Model\RecipientList> $recipients
	 */
	public function getRecipients() {
		return $this->recipients;
	}

	/**
	 * Sets the recipients
	 *
	 * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\LEO\NewsletterMan\Domain\Model\RecipientList> $recipients
	 * @return void
	 */
	public function setRecipients(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $recipients) {
		$this->recipients = $recipients;
	}

	/**
	 * Returns the sender
	 *
	 * @return \LEO\NewsletterMan\Domain\Model\Sender $sender
	 */
	public function getSender() {
		return $this->sender;
	}

	/**
	 * Sets the sender
	 *
	 * @param \LEO\NewsletterMan\Domain\Model\Sender $sender
	 * @return void
	 */
	public function setSender(\LEO\NewsletterMan\Domain\Model\Sender $sender) {
		$this->sender = $sender;
	}

}