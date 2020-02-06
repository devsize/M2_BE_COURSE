<?php

namespace Slayer\Test\Setup;

use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\UpgradeDataInterface;

/**
 * Class UpgradeData
 * Slayer\Test\Setup
 */
class UpgradeData implements UpgradeDataInterface
{
    /**
     * @param ModuleDataSetupInterface $setup
     * @param ModuleContextInterface $context
     */
    public function upgrade(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {
        // Used update query because all scopes needed to have this value updated and this is a fast, simple approach
        if (version_compare($context->getVersion(), '0.0.2', '<')) {
            $this->updateMyTableData($setup);
        }
    }

    /**
     * @param ModuleDataSetupInterface $setup
     */
    private function updateMyTableData($setup)
    {
        $myTable = $setup->getTable('my_orders_table');
        $data = [
            [
                'order_id' => 234123
            ],
            [
                'order_id' => 458563
            ],
            [
                'order_id' => 234245
            ],
            [
                'order_id' => 458890
            ],
            [
                'order_id' => 234324
            ],
            [
                'order_id' => 343023
            ],
            [
                'order_id' => 142423
            ],
            [
                'order_id' => 377423
            ]
        ];

        for ($i = 0; $i < count($data); $i++) {
            $setup->getConnection()->update(
                $myTable,
                $data[$i],
                ['entity_id = ?' => $i + 1]
            );
        }
    }
}