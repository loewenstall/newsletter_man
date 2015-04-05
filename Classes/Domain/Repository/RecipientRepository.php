<?php
namespace LEO\NewsletterMan\Domain\Repository;


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
use TYPO3\CMS\Extbase\Persistence\Generic\Query;

/**
 * The repository for Recipients
 */
class RecipientRepository extends \TYPO3\CMS\Extbase\Persistence\Repository {

	/**
	 * @param integer $pid
	 * @return \LEO\NewsletterMan\Domain\Model\Recipient
	 */
	public function findByPid($pid) {
		$this->ignoreQuerySettings();

		$query = $this->createQuery();
		$query->matching(
			$query->logicalAnd(
				$query->equals('pid', $pid),
				$query->equals('hidden', 0),
				$query->equals('deleted', 0)
			)
		);

		return $query->execute()->toArray();
	}

	/**
	 * @param string $hash
	 * @return \LEO\NewsletterMan\Domain\Model\Recipient
	 */
	public function findByHash($hash) {
		$this->ignoreQuerySettings();

		$query = $this->createQuery();
		$query->matching(
			$query->logicalAnd(
				$query->equals('hash', $hash),
				$query->equals('hidden', 1)
			)
		);

		return $query->execute()->current();
	}

	/**
	 * @param $recipientMail
	 * @return array|\TYPO3\CMS\Extbase\Persistence\QueryResultInterface
	 */
	public function findOnlyByMail($recipientMail) {
		$this->ignoreQuerySettings();

		$query = $this->createQuery();
		$query->matching(
			$query->equals('email', $recipientMail)
		);

		return $query->execute();
	}

	/**
	 * @param string $recipientMail
	 * @return \LEO\NewsletterMan\Domain\Model\Recipient
	 */
	public function findByMail($recipientMail) {
		$this->ignoreQuerySettings();

		$query = $this->createQuery();
		$query->matching(
			$query->logicalAnd(
				$query->equals('email', $recipientMail),
				$query->equals('hidden', 0)
			)
		);

		return $query->execute()->current();
	}

	/**
	 * @param integer $uid
	 * @return \LEO\NewsletterMan\Domain\Model\Recipient
	 */
	public function findInactive($uid) {
		$this->ignoreQuerySettings();

		return $this->findByIdentifier($uid);
	}

	protected function ignoreQuerySettings() {
		/** @var $querySettings \TYPO3\CMS\Extbase\Persistence\Generic\Typo3QuerySettings */
        $querySettings = $this->objectManager->get('TYPO3\\CMS\\Extbase\\Persistence\\Generic\\Typo3QuerySettings');
		$querySettings->setRespectStoragePage(false);
		$querySettings->setIgnoreEnableFields(true);

		$this->setDefaultQuerySettings($querySettings);
	}
}
