<?php

namespace Slayer\Test\Setup\Patch\Data;

use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\Patch\DataPatchInterface;
use Magento\Cms\Api\BlockRepositoryInterface;
use Magento\Cms\Model\Block;
use Magento\Cms\Model\BlockFactory;
use Psr\Log\LoggerInterface;

/**
 * Class CreatingNewCmsBlock
 * Slayer\Test\Setup\Patch\Data
 */
class CreatingNewCmsBlock implements DataPatchInterface
{

    /**
     * @var ModuleDataSetupInterface
     */
    private $moduleDataSetup;

    /**
     * @var BlockRepositoryInterface
     */
    private $blockRepository;

    /**
     * @var BlockFactory
     */
    private $blockFactory;

    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * Creating new cms block.
     * @param ModuleDataSetupInterface $moduleDataSetup
     * @param BlockRepositoryInterface $blockRepository
     * @param BlockFactory $blockFactory
     * @param LoggerInterface $logger
     */
    public function __construct(
        ModuleDataSetupInterface $moduleDataSetup,
        BlockRepositoryInterface $blockRepository,
        BlockFactory $blockFactory,
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
        $newCmsBlock = [
            'title' => 'Login for PLP Page',
            'identifier' => 'plp-page-login',
            'content' => '<div class="cms-plp-page">
                            <div class="cms-plp-page-login">user login</div>
                            <div class="cms-plp-page-password">user password</div>
                            <span>close</span>
                          </div>
            ',
            'is_active' => 1,
            'stores' => [1, 2],
            'sort_order' => 1
        ];

        $this->moduleDataSetup->startSetup();

        try {
            /**@var Block $block */
            $block = $this->blockFactory->create();
            $block->setData($newCmsBlock);
            $this->blockRepository->save($block);
        } catch (\Exception $exception) {
            $this->logger->debug('Cannot create "cms-plp-page" block!');
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