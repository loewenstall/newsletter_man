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
 * Test case for class \LEO\NewsletterMan\Domain\Model\Sender.
 *
 * @copyright Copyright belongs to the respective authors
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 * @author Marc Scherer <mail@loewenstall.de>
 */
class SenderTest extends \TYPO3\CMS\Core\Tests\UnitTestCase {
	/**
	 * @var \LEO\NewsletterMan\Domain\Model\Sender
	 */
	protected $subject = NULL;

	protected function setUp() {
		$this->subject = new \LEO\NewsletterMan\Domain\Model\Sender();
	}

	protected function tearDown() {
		unset($this->subject);
	}

	/**
	 * @test
	 */
	public function getSenderMailReturnsInitialValueForString() {
		$this->assertSame(
			'',
			$this->subject->getSenderMail()
		);
	}

	/**
	 * @test
	 */
	public function setSenderMailForStringSetsSenderMail() {
		$this->subject->setSenderMail('Conceived at T3CON10');

		$this->assertAttributeEquals(
			'Conceived at T3CON10',
			'senderMail',
			$this->subject
		);
	}

	/**
	 * @test
	 */
	public function getSenderNameReturnsInitialValueForString() {
		$this->assertSame(
			'',
			$this->subject->getSenderName()
		);
	}

	/**
	 * @test
	 */
	public function setSenderNameForStringSetsSenderName() {
		$this->subject->setSenderName('Conceived at T3CON10');

		$this->assertAttributeEquals(
			'Conceived at T3CON10',
			'senderName',
			$this->subject
		);
	}
}
