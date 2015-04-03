<?php
if (!defined('TYPO3_MODE')) {
	die('Access denied.');
}

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
	'LEO.' . $_EXTKEY,
	'Subscribe',
	array(
		'Recipient' => 'subscribe, save, done, confirm, actmail',
	),
	// non-cacheable actions
	array(
		'Recipient' => 'subscribe, save, done, confirm, actmail',
	)
);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
	'LEO.' . $_EXTKEY,
	'Unsubscribe',
	array(
		'Recipient' => 'unsubscribe, delete, done',
	),
	// non-cacheable actions
	array(
		'Recipient' => 'unsubscribe, delete, done',
	)
);
