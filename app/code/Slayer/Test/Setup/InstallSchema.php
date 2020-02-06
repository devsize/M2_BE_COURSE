<?php


namespace Slayer\Test\Setup;

use Magento\Framework\DB\Adapter\AdapterInterface;
use Magento\Framework\DB\Ddl\Table;
use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;

/**
 * Class InstallSchema
 * Slayer\Test\Setup
 */
class InstallSchema implements InstallSchemaInterface
{
    /**
     * @param SchemaSetupInterface $setup
     * @param ModuleContextInterface $context
     * @throws \Zend_Db_Exception
     */
    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $setup->startSetup();

        $tableName = $setup->getTable('my_customers_table');
        $table = $setup->getConnection()
            ->newTable($tableName)
            ->addColumn(
                'entity_id',
                Table::TYPE_SMALLINT,
                null,
                [
                    'identity' => true,
                    'nullable' => false,
                    'primary' => true
                ],
                'Entity Id'
            )
            ->addColumn(
                'name',
                Table::TYPE_TEXT,
                64,
                [
                    'nullable' => false
                ],
                'User Name'
            )
            ->addColumn(
                'surname',
                Table::TYPE_TEXT,
                64,
                [
                    'nullable' => false
                ],
                'User Surname'
            )
            ->addColumn(
                'email',
                Table::TYPE_TEXT,
                64,
                [
                    'nullable' => false
                ],
                'Email'
            )
            ->addColumn(
                'phone_number',
                Table::TYPE_BIGINT,
                13,
                [
                    'nullable' => true
                ],
                'Phone Number'
            )
            ->addColumn(
                'order_id',
                Table::TYPE_SMALLINT,
                null,
                [
                    'nullable' => false,
                    'default' => '0'
                ],
                'Order ID'
            )
            ->addIndex(
                $setup->getIdxName(
                    $tableName,
                    [
                        'email'
                    ],
                    AdapterInterface::INDEX_TYPE_UNIQUE
                ),
                [
                    'email'
                ],
                [
                    'type' => AdapterInterface::INDEX_TYPE_UNIQUE
                ]
            )
            ->setComment('My Customers Table!');
        $setup->getConnection()->createTable($table);

        $setup->endSetup();
    }
}