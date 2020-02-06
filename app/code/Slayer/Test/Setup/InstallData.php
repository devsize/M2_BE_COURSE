<?php


namespace Slayer\Test\Setup;

use Magento\Framework\Setup\InstallDataInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;

/**
 * Class InstallData
 *  Slayer\Test\Setup
 */
class InstallData implements InstallDataInterface
{
    /**
     * {@inheritDoc}
     */
    public function install(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {
        $myTable = $setup->getTable('my_customers_table');
        $data = [
            [
                'entity_id' => null,
                'name' => 'Maria',
                'surname' => 'Tkachuk',
                'email' => 'maria_tk@gmail.com',
                'phone_number' => +380975672567,
            ],
            [
                'entity_id' => null,
                'name' => 'Ivan',
                'surname' => 'Radchenko',
                'email' => 'ivan@gmail.com',
                'phone_number' => +380970854099,
            ],
            [
                'entity_id' => null,
                'name' => 'Roman',
                'surname' => 'Fedushun',
                'email' => 'rfedushun@gmail.com',
                'phone_number' => +380635852567,
            ],
            [
                'entity_id' => null,
                'name' => 'Ulyana',
                'surname' => 'Sidorenko',
                'email' => 'ulyasya@gmail.com',
                'phone_number' => +380960111117,
            ],
            [
                'entity_id' => null,
                'name' => 'Tanya',
                'surname' => 'Rak',
                'email' => 'tr@gmail.com',
                'phone_number' => +380980022566,
            ]
        ];

        $setup->getConnection()->insertMultiple($myTable, $data);
    }
}