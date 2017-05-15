<?php
/**
 * ext tables config file for ext: "formhandler"
 *
 * @author Reinhard Führicht <rf@typoheads.at>
 * @package    Tx_Formhandler
 */

if (!defined('TYPO3_MODE')) die ('Access denied.');

if (TYPO3_MODE === 'BE') {

    $file = 'FILE:EXT:' . $_EXTKEY . '/Configuration/FlexForms/flexform_ds.xml';

    // Add flexform DataStructure
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue('*', $file, $_EXTKEY . '_pi1');

    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPlugin(
        [
            'LLL:EXT:formhandler/Resources/Private/Language/locallang_db.xml:tt_content.list_type_pi1',
            $_EXTKEY . '_pi1'
        ],
        'CType'
    );

    \TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerModule(
        'Typoheads.' . $_EXTKEY,
        'web',
        'log',
        'bottom',
        [
            'Module' => 'index, view, selectFields, export, deleteLogRows'
        ],
        [
            'access' => 'user,group',
            'icon' => 'EXT:' . $_EXTKEY . '/Resources/Public/Icons/moduleicon.gif',
            'labels' => 'LLL:EXT:' . $_EXTKEY . '/Resources/Private/Language/locallang_mod.xml'
        ]
    );
}

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile($_EXTKEY, 'Configuration/TypoScript/ExampleConfiguration', 'Example Configuration');

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_formhandler_log');

$TCA['pages']['columns']['module']['config']['items'][] = [
    'LLL:EXT:' . $_EXTKEY . '/Resources/Private/Language/locallang.xml:title',
    'formlogs',
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extRelPath($_EXTKEY) . 'ext_icon.gif'
];
