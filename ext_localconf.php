<?php

if (!defined('TYPO3_MODE')) {
    die ('Access denied.');
}

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPItoST43('formhandler', 'pi1/class.tx_formhandler_pi1.php', '_pi1', 'CType', 0);

// load default PageTS config from static file
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPageTSConfig('<INCLUDE_TYPOSCRIPT: source="FILE:EXT:formhandler/Configuration/TypoScript/pageTsConfig.ts">');

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_formhandler_log');

$GLOBALS['TCA']['pages']['columns']['module']['config']['items'][] = [
    'LLL:EXT:formhandler/Resources/Private/Language/locallang.xml:title',
    'formlogs',
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extRelPath('formhandler') . 'ext_icon.gif'
];

//Hook in tslib_content->stdWrap
$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['tslib/class.tslib_content.php']['stdWrap']['formhandler'] = 'Typoheads\Formhandler\Hooks\StdWrapHook';

$GLOBALS['TYPO3_CONF_VARS']['FE']['eID_include']['formhandler'] = 'EXT:formhandler/Classes/Http/Validate.php';
$GLOBALS['TYPO3_CONF_VARS']['FE']['eID_include']['formhandler-removefile'] = 'EXT:formhandler/Classes/Http/RemoveFile.php';
$GLOBALS['TYPO3_CONF_VARS']['FE']['eID_include']['formhandler-ajaxsubmit'] = 'EXT:formhandler/Classes/Http/Submit.php';

if (!is_array($GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['scheduler']['tasks']['TYPO3\\CMS\\Scheduler\\Task\\TableGarbageCollectionTask']['options']['tables']['tx_formhandler_log'])) {
    $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['scheduler']['tasks']['TYPO3\\CMS\\Scheduler\\Task\\TableGarbageCollectionTask']['options']['tables']['tx_formhandler_log'] = [
        'dateField' => 'tstamp',
        'expirePeriod' => 180
    ];
}

$iconRegistry = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(
    \TYPO3\CMS\Core\Imaging\IconRegistry::class
);
$iconRegistry->registerIcon(
    'formhandler-foldericon',
    \TYPO3\CMS\Core\Imaging\IconProvider\BitmapIconProvider::class,
    ['source' => 'EXT:formhandler/Resources/Public/Images/pagetreeicon.png']
);
