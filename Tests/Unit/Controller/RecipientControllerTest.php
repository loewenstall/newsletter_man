<?php
namespace LEO\NewsletterMan\Tests\Unit\Controller;
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
 * Test case for class LEO\NewsletterMan\Controller\RecipientController.
 *
 * @author Marc Scherer <mail@loewenstall.de>
 */
class RecipientControllerTest extends \TYPO3\CMS\Core\Tests\UnitTestCase {

	/**
	 * @var \LEO\NewsletterMan\Controller\RecipientController
	 */
	protected $subject = NULL;

	protected function setUp() {
		$this->subject = $this->getMock('LEO\\NewsletterMan\\Controller\\RecipientController', array('redirect', 'forward', 'addFlashMessage'), array(), '', FALSE);
	}

	protected function tearDown() {
		unset($this->subject);
	}

	/**
	 * @test
	 */
	public function listActionFetchesAllRecipientsFromRepositoryAndAssignsThemToView() {

		$allRecipients = $this->getMock('TYPO3\\CMS\\Extbase\\Persistence\\ObjectStorage', array(), array(), '', FALSE);

		$recipientRepository = $this->getMock('LEO\\NewsletterMan\\Domain\\Repository\\RecipientRepository', array('findAll'), array(), '', FALSE);
		$recipientRepository->expects($this->once())->method('findAll')->will($this->returnValue($allRecipients));
		$this->inject($this->subject, 'recipientRepository', $recipientRepository);

		$view = $this->getMock('TYPO3\\CMS\\Extbase\\Mvc\\View\\ViewInterface');
		$view->expects($this->once())->method('assign')->with('recipients', $allRecipients);
		$this->inject($this->subject, 'view', $view);

		$this->subject->listAction();
	}
}
