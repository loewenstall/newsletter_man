<?php
if (!defined ('TYPO3_MODE')) {
	die ('Access denied.');
}

$GLOBALS['TCA']['tx_newsletterman_domain_model_recipient'] = array(
	'ctrl' => $GLOBALS['TCA']['tx_newsletterman_domain_model_recipient']['ctrl'],
	'interface' => array(
		'showRecordFieldList' => 'sys_language_uid, l10n_parent, l10n_diffsource, hidden, gender, email, title, first_name, last_name, street, zip, city',
	),
	'types' => array(
		'1' => array('showitem' => 'sys_language_uid;;;;1-1-1, l10n_parent, l10n_diffsource, hidden;;1, gender, email, title, first_name, last_name, street, zip, city'),
	),
	'palettes' => array(
		'1' => array('showitem' => ''),
	),
	'columns' => array(
		'sys_language_uid' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.language',
			'config' => array(
				'type' => 'select',
				'foreign_table' => 'sys_language',
				'foreign_table_where' => 'ORDER BY sys_language.title',
				'items' => array(
					array('LLL:EXT:lang/locallang_general.xlf:LGL.allLanguages', -1),
					array('LLL:EXT:lang/locallang_general.xlf:LGL.default_value', 0)
				),
			),
		),
		'l10n_parent' => array(
			'displayCond' => 'FIELD:sys_language_uid:>:0',
			'exclude' => 1,
			'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.l18n_parent',
			'config' => array(
				'type' => 'select',
				'items' => array(
					array('', 0),
				),
				'foreign_table' => 'tx_newsletterman_domain_model_recipient',
				'foreign_table_where' => 'AND tx_newsletterman_domain_model_recipient.pid=###CURRENT_PID### AND tx_newsletterman_domain_model_recipient.sys_language_uid IN (-1,0)',
			),
		),
		'l10n_diffsource' => array(
			'config' => array(
				'type' => 'passthrough',
			),
		),
		't3ver_label' => array(
			'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.versionLabel',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'max' => 255,
			)
		),
		'hidden' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.hidden',
			'config' => array(
				'type' => 'check',
			),
		),
		'starttime' => array(
			'exclude' => 1,
			'l10n_mode' => 'mergeIfNotBlank',
			'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.starttime',
			'config' => array(
				'type' => 'input',
				'size' => 13,
				'max' => 20,
				'eval' => 'datetime',
				'checkbox' => 0,
				'default' => 0,
				'range' => array(
					'lower' => mktime(0, 0, 0, date('m'), date('d'), date('Y'))
				),
			),
		),
		'endtime' => array(
			'exclude' => 1,
			'l10n_mode' => 'mergeIfNotBlank',
			'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.endtime',
			'config' => array(
				'type' => 'input',
				'size' => 13,
				'max' => 20,
				'eval' => 'datetime',
				'checkbox' => 0,
				'default' => 0,
				'range' => array(
					'lower' => mktime(0, 0, 0, date('m'), date('d'), date('Y'))
				),
			),
		),
		'gender' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:newsletter_man/Resources/Private/Language/locallang_db.xlf:tx_newsletterman_domain_model_recipient.gender',
			'config' => array(
				'type' => 'select',
				'items' => array(
					array('LLL:EXT:newsletter_man/Resources/Private/Language/locallang.xlf:gender.default', 'none'),
					array('LLL:EXT:newsletter_man/Resources/Private/Language/locallang.xlf:gender.mrs', 'mrs'),
					array('LLL:EXT:newsletter_man/Resources/Private/Language/locallang.xlf:gender.mr', 'mr'),
				),
				'size' => 1,
				'maxitems' => 1,
				'eval' => ''
			),
		),
		'email' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:newsletter_man/Resources/Private/Language/locallang_db.xlf:tx_newsletterman_domain_model_recipient.email',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim, required'
			),
		),
		'title' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:newsletter_man/Resources/Private/Language/locallang_db.xlf:tx_newsletterman_domain_model_recipient.title',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim'
			),
		),
		'first_name' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:newsletter_man/Resources/Private/Language/locallang_db.xlf:tx_newsletterman_domain_model_recipient.first_name',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim'
			),
		),
		'last_name' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:newsletter_man/Resources/Private/Language/locallang_db.xlf:tx_newsletterman_domain_model_recipient.last_name',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim'
			),
		),
		'street' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:newsletter_man/Resources/Private/Language/locallang_db.xlf:tx_newsletterman_domain_model_recipient.street',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim'
			),
		),
		'zip' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:newsletter_man/Resources/Private/Language/locallang_db.xlf:tx_newsletterman_domain_model_recipient.zip',
			'config' => array(
				'type' => 'input',
				'size' => 7,
				'eval' => 'trim'
			),
		),
		'city' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:newsletter_man/Resources/Private/Language/locallang_db.xlf:tx_newsletterman_domain_model_recipient.city',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim'
			),
		),
		'hash' => array(
			'config' => array(
				'type' => 'passthrough',
			),
		),
		'recipientlist' => array(
			'config' => array(
				'type' => 'passthrough',
			),
		),
	),
);
