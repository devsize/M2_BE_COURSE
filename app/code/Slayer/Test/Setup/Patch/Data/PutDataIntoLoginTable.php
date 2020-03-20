<?php

namespace Slayer\Test\Setup\Patch\Data;

use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\Patch\DataPatchInterface;
use Psr\Log\LoggerInterface;

/**
 * Class PutDataIntoMyNewTable
 * Slayer\Test\Setup\Patch\Data
 */
class PutDataIntoLoginTable implements DataPatchInterface
{
    const MY_LOGIN_TABLE = 'my_login_table';

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
        $this->blockRepository = $blockRepository;
        $this->blockFactory = $blockFactory;
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
                'user_id' => 1,
                'login' => 'masha',
                'password' => '11123',
                'created_at' => ''
            ],
            [
                'entity_id' => null,
                'user_id' => 2,
                'login' => 'vanya',
                'password' => '1232234',
                'created_at' => ''
            ],
            [
                'entity_id' => null,
                'user_id' => 3,
                'login' => 'roma',
                'password' => '12345',
                'created_at' => ''
            ],
            [
                'entity_id' => null,
                'user_id' => 4,
                'login' => 'ulya',
                'password' => '123000',
                'created_at' => ''
            ],
            [
                'entity_id' => null,
                'user_id' => 5,
                'login' => 'tanya',
                'password' => '1211113',
                'created_at' => ''
            ],
            [
                'entity_id' => null,
                'user_id' => 7,
                'login' => 'olega',
                'password' => '324344',
                'created_at' => ''
            ],

        ];

        $this->moduleDataSetup->startSetup();

        try {
            $connection = $this->moduleDataSetup->getConnection();
            foreach ($data as $row) {
                $row['created_at'] = date("Y-m-d H:i:s");
                $connection->insert(self::MY_LOGIN_TABLE, $row);
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