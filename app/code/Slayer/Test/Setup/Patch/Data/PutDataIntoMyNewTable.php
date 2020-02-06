<?php

namespace Slayer\Test\Setup\Patch\Data;

use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\Patch\DataPatchInterface;
use Psr\Log\LoggerInterface;

/**
 * Class PutDataIntoMyNewTable
 * Slayer\Test\Setup\Patch\Data
 */
class PutDataIntoMyNewTable implements DataPatchInterface
{
    const MY_ORDERS_TABLE = 'my_orders_table';

    /**
     * @var ModuleDataSetupInterface
     */
    private $moduleDataSetup;

    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * PutDataIntoMyNewTable constructor.
     * @param ModuleDataSetupInterface $moduleDataSetup
     * @param LoggerInterface $logger
     */
    public function __construct(
        ModuleDataSetupInterface $moduleDataSetup,
        LoggerInterface $logger
    ) {
        $this->moduleDataSetup = $moduleDataSetup;
        $this->logger = $logger;
    }

    /**
     * {@inheritdoc}
     */
    public function apply()
    {
        $data = [
            [
                'entity_id' => null,
                'user_id' => 2,
                'order_id' => 234123,
                'order_name' => 'book1',
                'created_at' => '',
                'price' => 23.02

            ],
            [
                'entity_id' => null,
                'user_id' => 2,
                'order_id' => 458563,
                'order_name' => 'book2',
                'created_at' => '',
                'price' => 10.15
            ],
            [
                'entity_id' => null,
                'user_id' => 3,
                'order_id' => 234245,
                'order_name' => 'book3',
                'created_at' => '',
                'price' => 58.02
            ],
            [
                'entity_id' => null,
                'user_id' => 1,
                'order_id' => 458890,
                'order_name' => 'book4',
                'created_at' => '',
                'price' => 187.00
            ],
            [
                'entity_id' => null,
                'user_id' => 4,
                'order_id' => 234324,
                'order_name' => 'book5',
                'created_at' => '',
                'price' => 99.99
            ],
            [
                'entity_id' => null,
                'user_id' => 5,
                'order_id' => 343023,
                'order_name' => 'book5',
                'created_at' => '',
                'price' => 99.99
            ],
            [
                'entity_id' => null,
                'user_id' => 5,
                'order_id' => 142423,
                'order_name' => 'book5',
                'created_at' => '',
                'price' => 99.99
            ],
            [
                'entity_id' => null,
                'user_id' => 1,
                'order_id' => 377423,
                'order_name' => 'book5',
                'created_at' => '',
                'price' => 99.99
            ]
        ];

        $this->moduleDataSetup->startSetup();

        try {
            $connection = $this->moduleDataSetup->getConnection();
//            die('some text' . time());
            foreach ($data as $row) {
                $row['created_at'] = date("Y-m-d H:i:s");
                $connection->insert(self::MY_ORDERS_TABLE, $row);
            }
        } catch (\Exception $exception) {
            $this->logger->debug('Cannot insert row, message: "'. $exception->getMessage() . '"');
        }

        $this->moduleDataSetup->endSetup();
    }

    /**
     * {@inheritdoc}
     */
    public static function getDependencies()
    {
        return [];
    }

    /**
     * {@inheritdoc}
     */
    public function getAliases()
    {
        return [];
    }
}