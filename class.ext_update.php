<?php
namespace Typoheads\Formhandler;

use TYPO3\CMS\Backend\Utility\BackendUtility;

class ext_update
{
    public function main()
    {
        $pluginsToMigrate = $this->countListTypePlugins();
        if ($pluginsToMigrate > 0) {
            $this->migrateListTypePlugins();
        }
        $remainingPluginsToMigrate = $this->countListTypePlugins();
        if ($remainingPluginsToMigrate === 0) {
            return "Success: Migrated $pluginsToMigrate formhandler plugins from list_type to CType. The forms should now show up again in the frontend.";
        } else {
            return "Error: $pluginsToMigrate formhandler plugins should have been migrated, but $remainingPluginsToMigrate are still left.";
        }
    }

    /**
     * Activate update script if any pre 2.1 plugins are in the database
     *
     * @return bool
     */
    public function access()
    {
        return $this->countListTypePlugins() > 0;
    }

    private function countListTypePlugins()
    {
        return $this->getDb()->exec_SELECTcountRows(
            '*',
            'tt_content',
            'CType = \'list\' AND list_type = \'formhandler_pi1\'' . BackendUtility::deleteClause('tt_content')
        );
    }

    private function migrateListTypePlugins()
    {
        $this->getDb()->exec_UPDATEquery(
            'tt_content',
            'CType = \'list\' AND list_type = \'formhandler_pi1\'' . BackendUtility::deleteClause('tt_content'),
            [
                'CType' => 'formhandler_pi1'
            ]
        );
    }

    /**
     * @return \TYPO3\CMS\Core\Database\DatabaseConnection
     */
    private function getDb()
    {
        return $GLOBALS['TYPO3_DB'];
    }
}
