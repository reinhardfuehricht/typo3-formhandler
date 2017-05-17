<?php



\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerModule(
    'Typoheads.' . 'formhandler',
    'web',
    'log',
    'bottom',
    [
        'Module' => 'index, view, selectFields, export, deleteLogRows'
    ],
    [
        'access' => 'user,group',
        'icon' => 'EXT:formhandler/Resources/Public/Icons/moduleicon.gif',
        'labels' => 'LLL:EXT:formhandler/Resources/Private/Language/locallang_mod.xml'
    ]
);