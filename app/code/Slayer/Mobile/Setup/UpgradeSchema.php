<?php

namespace Slayer\Mobile\Setup;

use Magento\Framework\DB\Ddl\Table;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\Setup\UpgradeSchemaInterface;

/**
 * Class UpgradeSchema
 * Slayer\Test\Setup
 */
class UpgradeSchema implements UpgradeSchemaInterface
{
    /**
     * @param SchemaSetupInterface $setup
     * @param ModuleContextInterface $context
     */
    public function upgrade(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $moduleVersion = $context->getVersion();
        if (version_compare($moduleVersion, '0.0.2', '<')) {
            $this->updateMyTable($setup);
        }
    }

    /**
     * @param SchemaSetupInterface $setup
     */
    private function updateMyTable($setup)
    {
        $setup->startSetup();

        /**
         * Add full text index to mobile_manufacturer_table
         */
        $tableName = $setup->getTable('mobile_manufacturer_table');
        $fullTextIndex = ['name', 'director', 'phone', 'email', 'address'];

        $setup->getConnection()->addIndex(
            $tableName,
            $setup->getIdxName(
                $tableName,
                $fullTextIndex,
                \Magento\Framework\DB\Adapter\AdapterInterface::INDEX_TYPE_FULLTEXT
            ),
            $fullTextIndex,
            \Magento\Framework\DB\Adapter\AdapterInterface::INDEX_TYPE_FULLTEXT
        );

        /**
         * Add full text index to mobile_phone_table
         */
        $tableName = $setup->getTable('mobile_phone_table');
        $fullTextIndex = ['model', 'os', 'resolution', 'ram', 'cpu', 'battery', 'description', 'released'];

        $setup->getConnection()->addIndex(
            $tableName,
            $setup->getIdxName(
                $tableName,
                $fullTextIndex,
                \Magento\Framework\DB\Adapter\AdapterInterface::INDEX_TYPE_FULLTEXT
            ),
            $fullTextIndex,
            \Magento\Framework\DB\Adapter\AdapterInterface::INDEX_TYPE_FULLTEXT
        );

        $setup->endSetup();
    }
}
