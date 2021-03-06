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
 * List of recipients
 */
class RecipientList extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity {

	/**
	 * name
	 *
	 * @var string
	 */
	protected $name = '';

	/**
	 * recipients
	 *
	 * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\LEO\NewsletterMan\Domain\Model\Pages>
	 */
	protected $recipients = NULL;

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
	 * Returns the name
	 *
	 * @return string $name
	 */
	public function getName() {
		return $this->name;
	}

	/**
	 * Sets the name
	 *
	 * @param string $name
	 * @return void
	 */
	public function setName($name) {
		$this->name = $name;
	}

	/**
	 * Adds a Recipients
	 *
	 * @param \LEO\NewsletterMan\Domain\Model\Pages $recipient
	 * @return void
	 */
	public function addRecipients($recipient) {
		$this->recipients->attach($recipient);
	}

	/**
	 * Removes a Recipient
	 *
	 * @param \LEO\NewsletterMan\Domain\Model\Pages $recipientToRemove The Recipient to be removed
	 * @return void
	 */
	public function removeRecipients($recipientToRemove) {
		$this->recipients->detach($recipientToRemove);
	}

	/**
	 * Returns the recipients
	 *
	 * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\LEO\NewsletterMan\Domain\Model\Pages> $recipients
	 */
	public function getRecipients() {
		return $this->recipients;
	}

	/**
	 * Sets the recipient
	 *
	 * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\LEO\NewsletterMan\Domain\Model\Pages> $recipient
	 * @return void
	 */
	public function setRecipients(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $recipient) {
		$this->recipients = $recipient;
	}

}
