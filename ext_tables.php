<?php
if (!defined('TYPO3_MODE')) {
	die('Access denied.');
}

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
	$_EXTKEY,
	'Subscribe',
	'Newsletter subscription'
);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
	$_EXTKEY,
	'Unsubscribe',
	'Newsletter unsubscribe'
);

// add flexforms
$extensionName = strtolower(\TYPO3\CMS\Core\Utility\GeneralUtility::underscoredToUpperCamelCase($_EXTKEY));
$pluginSignature = $extensionName . '_subscribe';

$TCA['tt_content']['types']['list']['subtypes_excludelist'][$pluginSignature] = 'layout,select_key,pages';
$TCA['tt_content']['types']['list']['subtypes_addlist'][$pluginSignature] = 'pi_flexform';

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue($pluginSignature, 'FILE:EXT:newsletter_man/Configuration/FlexForms/Subscribe.xml');

$pluginSignature = $extensionName . '_unsubscribe';

$TCA['tt_content']['types']['list']['subtypes_excludelist'][$pluginSignature] = 'layout,select_key,pages';
$TCA['tt_content']['types']['list']['subtypes_addlist'][$pluginSignature] = 'pi_flexform';

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue($pluginSignature, 'FILE:EXT:newsletter_man/Configuration/FlexForms/Unsubscribe.xml');

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile($_EXTKEY, 'Configuration/TypoScript', 'Newsletter Manager');

// be module
if (TYPO3_MODE === 'BE') {
	/**
	 * Registers a Backend Module
	 * tx_newsletterman_web_newslettermanadmin
	 */
	\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerModule(
		'LEO.' . $_EXTKEY,
		'web',	 // Make module a submodule of 'web'
		'admin',	// Submodule key
		'',						// Position
		array(
			'Newsletter' => 'list, show, new, create, edit, update, delete, send',
			'RecipientList' => 'list, show, new, create, edit, update, delete',
		),
		array(
			'access' => 'user,group',
			'icon'   => 'EXT:' . $_EXTKEY . '/ext_icon.png',
			'labels' => 'LLL:EXT:' . $_EXTKEY . '/Resources/Private/Language/locallang_mod.xlf',
		)
	);
}

// add new doktype to the list of page types
$customPageIcon = 'EXT:' . $_EXTKEY . 'Resources/Public/Images/page_icon.png';

$GLOBALS['PAGES_TYPES'][166] = array(
	'type' => 'newsletter',
	'icon' => $customPageIcon,
	'allowedTables' => '*'
);

// add the new doktype to the page type selector
$GLOBALS['TCA']['pages']['columns']['doktype']['config']['items'][] = array(
	'LLL:EXT:' . $_EXTKEY . '/Resources/Private/Language/locallang_db.xlf:newsletter_page_type',
	166,
	$customPageIcon
);

$GLOBALS['TCA']['pages_language_overlay']['columns']['doktype']['config']['items'][] = array(
     'LLL:EXT:' . $_EXTKEY . '/Resources/Private/Language/locallang_db.xlf:newsletter_page_type',
	166,
	$customPageIcon
);

// add the icon for the new doktype
\TYPO3\CMS\Backend\Sprite\SpriteManager::addTcaTypeIcon('newsletter', 166, $customPageIcon);

// add the new doktype to the list of types available from the new page menu at the top of the page tree
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addUserTSConfig(
        'options.pageTree.doktypesToShowInNewPageDragArea := addToList(' . 166 . ')'
);

// tca
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_newsletterman_domain_model_newsletter', 'EXT:newsletter_man/Resources/Private/Language/locallang_csh_tx_newsletterman_domain_model_newsletter.xlf');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_newsletterman_domain_model_newsletter');
$GLOBALS['TCA']['tx_newsletterman_domain_model_newsletter'] = array(
	'ctrl' => array(
		'title'	=> 'LLL:EXT:newsletter_man/Resources/Private/Language/locallang_db.xlf:tx_newsletterman_domain_model_newsletter',
		'label' => 'send_date',
		'tstamp' => 'tstamp',
		'crdate' => 'crdate',
		'cruser_id' => 'cruser_id',
		'dividers2tabs' => TRUE,

		'versioningWS' => 2,
		'versioning_followPages' => TRUE,

		'languageField' => 'sys_language_uid',
		'transOrigPointerField' => 'l10n_parent',
		'transOrigDiffSourceField' => 'l10n_diffsource',
		'delete' => 'deleted',
		'enablecolumns' => array(
			'disabled' => 'hidden',
			'starttime' => 'starttime',
			'endtime' => 'endtime',
		),
		'searchFields' => 'send_date,page,state,recipients,sender,',
		'dynamicConfigFile' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath($_EXTKEY) . 'Configuration/TCA/Newsletter.php',
		'iconfile' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extRelPath($_EXTKEY) . 'Resources/Public/Icons/tx_newsletterman_domain_model_newsletter.gif'
	),
);

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_newsletterman_domain_model_recipientlist', 'EXT:newsletter_man/Resources/Private/Language/locallang_csh_tx_newsletterman_domain_model_recipientlist.xlf');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_newsletterman_domain_model_recipientlist');
$GLOBALS['TCA']['tx_newsletterman_domain_model_recipientlist'] = array(
	'ctrl' => array(
		'title'	=> 'LLL:EXT:newsletter_man/Resources/Private/Language/locallang_db.xlf:tx_newsletterman_domain_model_recipientlist',
		'label' => 'name',
		'tstamp' => 'tstamp',
		'crdate' => 'crdate',
		'cruser_id' => 'cruser_id',
		'dividers2tabs' => TRUE,

		'versioningWS' => 2,
		'versioning_followPages' => TRUE,

		'languageField' => 'sys_language_uid',
		'transOrigPointerField' => 'l10n_parent',
		'transOrigDiffSourceField' => 'l10n_diffsource',
		'delete' => 'deleted',
		'enablecolumns' => array(
			'disabled' => 'hidden',
			'starttime' => 'starttime',
			'endtime' => 'endtime',
		),
		'searchFields' => 'name,recipient,',
		'dynamicConfigFile' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath($_EXTKEY) . 'Configuration/TCA/RecipientList.php',
		'iconfile' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extRelPath($_EXTKEY) . 'Resources/Public/Icons/tx_newsletterman_domain_model_recipientlist.gif'
	),
);

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_newsletterman_domain_model_recipient', 'EXT:newsletter_man/Resources/Private/Language/locallang_csh_tx_newsletterman_domain_model_recipient.xlf');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_newsletterman_domain_model_recipient');
$GLOBALS['TCA']['tx_newsletterman_domain_model_recipient'] = array(
	'ctrl' => array(
		'title'	=> 'LLL:EXT:newsletter_man/Resources/Private/Language/locallang_db.xlf:tx_newsletterman_domain_model_recipient',
		'label' => 'email',
		'tstamp' => 'tstamp',
		'crdate' => 'crdate',
		'cruser_id' => 'cruser_id',
		'dividers2tabs' => TRUE,

		'versioningWS' => 2,
		'versioning_followPages' => TRUE,

		'languageField' => 'sys_language_uid',
		'transOrigPointerField' => 'l10n_parent',
		'transOrigDiffSourceField' => 'l10n_diffsource',
		'delete' => 'deleted',
		'enablecolumns' => array(
			'disabled' => 'hidden',
			'starttime' => 'starttime',
			'endtime' => 'endtime',
		),
		'searchFields' => 'gender,email,title,first_name,last_name,street,zip,city,',
		'dynamicConfigFile' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath($_EXTKEY) . 'Configuration/TCA/Recipient.php',
		'iconfile' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extRelPath($_EXTKEY) . 'Resources/Public/Icons/tx_newsletterman_domain_model_recipient.gif'
	),
);

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_newsletterman_domain_model_sender', 'EXT:newsletter_man/Resources/Private/Language/locallang_csh_tx_newsletterman_domain_model_sender.xlf');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_newsletterman_domain_model_sender');
$GLOBALS['TCA']['tx_newsletterman_domain_model_sender'] = array(
	'ctrl' => array(
		'title'	=> 'LLL:EXT:newsletter_man/Resources/Private/Language/locallang_db.xlf:tx_newsletterman_domain_model_sender',
		'label' => 'sender_mail',
		'tstamp' => 'tstamp',
		'crdate' => 'crdate',
		'cruser_id' => 'cruser_id',
		'dividers2tabs' => TRUE,

		'versioningWS' => 2,
		'versioning_followPages' => TRUE,

		'languageField' => 'sys_language_uid',
		'transOrigPointerField' => 'l10n_parent',
		'transOrigDiffSourceField' => 'l10n_diffsource',
		'delete' => 'deleted',
		'enablecolumns' => array(
			'disabled' => 'hidden',
			'starttime' => 'starttime',
			'endtime' => 'endtime',
		),
		'searchFields' => 'sender_mail,sender_name,',
		'dynamicConfigFile' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath($_EXTKEY) . 'Configuration/TCA/Sender.php',
		'iconfile' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extRelPath($_EXTKEY) . 'Resources/Public/Icons/tx_newsletterman_domain_model_sender.gif'
	),
);
