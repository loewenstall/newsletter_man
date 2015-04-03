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
 * Sender informations
 */
class Sender extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity {

	/**
	 * senderMail
	 *
	 * @var string
	 */
	protected $senderMail = '';

	/**
	 * senderName
	 *
	 * @var string
	 */
	protected $senderName = '';

	/**
	 * Returns the senderMail
	 *
	 * @return string $senderMail
	 */
	public function getSenderMail() {
		return $this->senderMail;
	}

	/**
	 * Sets the senderMail
	 *
	 * @param string $senderMail
	 * @return void
	 */
	public function setSenderMail($senderMail) {
		$this->senderMail = $senderMail;
	}

	/**
	 * Returns the senderName
	 *
	 * @return string $senderName
	 */
	public function getSenderName() {
		return $this->senderName;
	}

	/**
	 * Sets the senderName
	 *
	 * @param string $senderName
	 * @return void
	 */
	public function setSenderName($senderName) {
		$this->senderName = $senderName;
	}

}