<?php

namespace LEO\NewsletterMan\Tests\Unit\Domain\Model;

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2015 Marc Scherer <mail@loewenstall.de>, LÖWENSTALL
 *
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 2 of the License, or
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
 * Test case for class \LEO\NewsletterMan\Domain\Model\Newsletter.
 *
 * @copyright Copyright belongs to the respective authors
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 * @author Marc Scherer <mail@loewenstall.de>
 */
class NewsletterTest extends \TYPO3\CMS\Core\Tests\UnitTestCase {
	/**
	 * @var \LEO\NewsletterMan\Domain\Model\Newsletter
	 */
	protected $subject = NULL;

	protected function setUp() {
		$this->subject = new \LEO\NewsletterMan\Domain\Model\Newsletter();
	}

	protected function tearDown() {
		unset($this->subject);
	}

	/**
	 * @test
	 */
	public function getSendDateReturnsInitialValueForDateTime() {
		$this->assertEquals(
			NULL,
			$this->subject->getSendDate()
		);
	}

	/**
	 * @test
	 */
	public function setSendDateForDateTimeSetsSendDate() {
		$dateTimeFixture = new \DateTime();
		$this->subject->setSendDate($dateTimeFixture);

		$this->assertAttributeEquals(
			$dateTimeFixture,
			'sendDate',
			$this->subject
		);
	}

	/**
	 * @test
	 */
	public function getPageReturnsInitialValueForInteger() {
		$this->assertSame(
			0,
			$this->subject->getPage()
		);
	}

	/**
	 * @test
	 */
	public function setPageForIntegerSetsPage() {
		$this->subject->setPage(12);

		$this->assertAttributeEquals(
			12,
			'page',
			$this->subject
		);
	}

	/**
	 * @test
	 */
	public function getStateReturnsInitialValueForInteger() {
		$this->assertSame(
			0,
			$this->subject->getState()
		);
	}

	/**
	 * @test
	 */
	public function setStateForIntegerSetsState() {
		$this->subject->setState(12);

		$this->assertAttributeEquals(
			12,
			'state',
			$this->subject
		);
	}

	/**
	 * @test
	 */
	public function getRecipientsReturnsInitialValueForRecipientList() {
		$newObjectStorage = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
		$this->assertEquals(
			$newObjectStorage,
			$this->subject->getRecipients()
		);
	}

	/**
	 * @test
	 */
	public function setRecipientsForObjectStorageContainingRecipientListSetsRecipients() {
		$recipient = new \LEO\NewsletterMan\Domain\Model\RecipientList();
		$objectStorageHoldingExactlyOneRecipients = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
		$objectStorageHoldingExactlyOneRecipients->attach($recipient);
		$this->subject->setRecipients($objectStorageHoldingExactlyOneRecipients);

		$this->assertAttributeEquals(
			$objectStorageHoldingExactlyOneRecipients,
			'recipients',
			$this->subject
		);
	}

	/**
	 * @test
	 */
	public function addRecipientToObjectStorageHoldingRecipients() {
		$recipient = new \LEO\NewsletterMan\Domain\Model\RecipientList();
		$recipientsObjectStorageMock = $this->getMock('TYPO3\\CMS\\Extbase\\Persistence\\ObjectStorage', array('attach'), array(), '', FALSE);
		$recipientsObjectStorageMock->expects($this->once())->method('attach')->with($this->equalTo($recipient));
		$this->inject($this->subject, 'recipients', $recipientsObjectStorageMock);

		$this->subject->addRecipient($recipient);
	}

	/**
	 * @test
	 */
	public function removeRecipientFromObjectStorageHoldingRecipients() {
		$recipient = new \LEO\NewsletterMan\Domain\Model\RecipientList();
		$recipientsObjectStorageMock = $this->getMock('TYPO3\\CMS\\Extbase\\Persistence\\ObjectStorage', array('detach'), array(), '', FALSE);
		$recipientsObjectStorageMock->expects($this->once())->method('detach')->with($this->equalTo($recipient));
		$this->inject($this->subject, 'recipients', $recipientsObjectStorageMock);

		$this->subject->removeRecipient($recipient);

	}

	/**
	 * @test
	 */
	public function getSenderReturnsInitialValueForSender() {
		$this->assertEquals(
			NULL,
			$this->subject->getSender()
		);
	}

	/**
	 * @test
	 */
	public function setSenderForSenderSetsSender() {
		$senderFixture = new \LEO\NewsletterMan\Domain\Model\Sender();
		$this->subject->setSender($senderFixture);

		$this->assertAttributeEquals(
			$senderFixture,
			'sender',
			$this->subject
		);
	}
}
