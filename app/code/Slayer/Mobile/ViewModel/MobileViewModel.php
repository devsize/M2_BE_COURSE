<?php

namespace Slayer\Mobile\ViewModel;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\Event\ManagerInterface as EventManager;
use Magento\Framework\View\Element\Block\ArgumentInterface;
use Psr\Log\LoggerInterface;

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
     * @var LoggerInterface
     */
    private $_logger;

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
            $date = new \DateTime('now');
            $result = $date->format('d-M-yy');
        } catch (\Exception $exception) {
            $error = $exception->getMessage();
            $text = 'Loading current date has failed: message "%s"';
            $message = sprintf($text, $error);
            $this->_logger->debug($message);
        }

        return $result;
    }

    /**
     * @return int
     */
    public function showManufacturersCountPerPage()
    {
        return (int)$this->scopeConfig->getValue(self::MANUFACTURERS_COUNT);
    }
}
