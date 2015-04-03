<?php
if (!defined ('TYPO3_MODE')) {
	die ('Access denied.');
}

$GLOBALS['TCA']['tx_newsletterman_domain_model_newsletter'] = array(
	'ctrl' => $GLOBALS['TCA']['tx_newsletterman_domain_model_newsletter']['ctrl'],
	'interface' => array(
		'showRecordFieldList' => 'sys_language_uid, l10n_parent, l10n_diffsource, hidden, send_date, page, state, recipients, sender',
	),
	'types' => array(
		'1' => array('showitem' => 'sys_language_uid;;;;1-1-1, l10n_parent, l10n_diffsource, hidden;;1, send_date, page, state, recipients, sender'),
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
				'foreign_table' => 'tx_newsletterman_domain_model_newsletter',
				'foreign_table_where' => 'AND tx_newsletterman_domain_model_newsletter.pid=###CURRENT_PID### AND tx_newsletterman_domain_model_newsletter.sys_language_uid IN (-1,0)',
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
		'send_date' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:newsletter_man/Resources/Private/Language/locallang_db.xlf:tx_newsletterman_domain_model_newsletter.send_date',
			'config' => array(
				'dbType' => 'datetime',
				'type' => 'input',
				'size' => 12,
				'eval' => 'datetime',
				'checkbox' => 0,
				'default' => '0000-00-00 00:00:00'
			),
		),
		'page' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:newsletter_man/Resources/Private/Language/locallang_db.xlf:tx_newsletterman_domain_model_newsletter.page',
			'config' => array(
				'type' => 'group',
				'internal_type' => 'db',
				'allowed' => 'pages',
				'size' => 1,
				'maxitems' => 1,
				'eval' => ''
			),
		),
		'state' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:newsletter_man/Resources/Private/Language/locallang_db.xlf:tx_newsletterman_domain_model_newsletter.state',
			'config' => array(
				'type' => 'check',
				'value' => 1,
				'eval' => 'int'
			)
		),
		'recipients' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:newsletter_man/Resources/Private/Language/locallang_db.xlf:tx_newsletterman_domain_model_newsletter.recipients',
			'config' => array(
				'type' => 'group',
				'internal_type' => 'db',
				'allowed' => 'tx_newsletterman_domain_model_recipientlist',
				'maxitems'      => 9999,
			),
		),
		'sender' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:newsletter_man/Resources/Private/Language/locallang_db.xlf:tx_newsletterman_domain_model_newsletter.sender',
			'config' => array(
				'type' => 'select',
				'foreign_table' => 'tx_newsletterman_domain_model_sender',
				'minitems' => 1,
				'maxitems' => 1,
			),
		),
	),
);
