<?php

defined('TYPO3_MODE') || die ('Access denied.');

// Adding the plugins TypoScript:
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTypoScript('formhandler', 'setup', '
# Setting formhandler plugin TypoScript
plugin.tx_formhandler_pi1 = USER
plugin.tx_formhandler_pi1.userFunc = Typoheads\Formhandler\Controller\Dispatcher->main

tt_content.formhandler_pi1 = COA
tt_content.formhandler_pi1 {
    10 < plugin.tx_formhandler_pi1
}
');

//Hook in tslib_content->stdWrap
$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['tslib/class.tslib_content.php']['stdWrap'][$_EXTKEY] = 'Typoheads\Formhandler\Hooks\StdWrapHook';

$GLOBALS['TYPO3_CONF_VARS']['FE']['eID_include']['formhandler'] = 'EXT:formhandler/Classes/Http/Validate.php';
$GLOBALS['TYPO3_CONF_VARS']['FE']['eID_include']['formhandler-removefile'] = 'EXT:formhandler/Classes/Http/RemoveFile.php';
$GLOBALS['TYPO3_CONF_VARS']['FE']['eID_include']['formhandler-ajaxsubmit'] = 'EXT:formhandler/Classes/Http/Submit.php';

// load default PageTS config from static file
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPageTSConfig('<INCLUDE_TYPOSCRIPT: source="FILE:EXT:' . $_EXTKEY . '/Configuration/TypoScript/pageTsConfig.ts">');

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
