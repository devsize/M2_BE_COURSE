<?php

namespace Slayer\Mobile\ViewModel;

use Magento\Framework\View\Element\Block\ArgumentInterface;
use Magento\Framework\Event\ManagerInterface as EventManager;
use Magento\Framework\App\Config\ScopeConfigInterface;

/**
 * Class MobileViewModel
 */
class MobileViewModel implements ArgumentInterface
{

    const MANUFACTURERS_COUNT = 'slayer_mobile/mobile_settings/manufacturers_count';

    /**
     * @var EventManager
     */
    private $eventManager;

    /**
     * @var ScopeConfigInterface
     */
    private $scopeConfig;

    /**
     * @param ScopeConfigInterface $scopeConfig
     * @param EventManager $eventManager
     */
    public function __construct(
        ScopeConfigInterface $scopeConfig,
        EventManager $eventManager
    ) {
        $this->scopeConfig = $scopeConfig;
        $this->eventManager = $eventManager;
    }

    /**
     * @return string
     */
    public function getCurrentDate()
    {
        $result = '';
        try {
            $this->eventManager->dispatch('manufacturers_block_current_date_before');
            $date = new \DateTime('now');
            $result = $date->format('d-M-yy');
            $this->eventManager->dispatch('manufacturers_block_current_date_after');
        } catch (\Exception $exception) {
            $message = "Error happened during application run.\n";
            $message .= $exception->getMessage();
            throw new \DomainException($message);
        }

        return $result;
    }

    /**
     * @return int
     */
    public function showManufacturersCountPerPage()
    {
        $result = null;
        try {
            $result = (int)$this->scopeConfig->getValue(self::MANUFACTURERS_COUNT);
        } catch (\Exception $exception) {
            $exception->getMessage();
        }
        return $result;
    }
}
