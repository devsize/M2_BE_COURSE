<?php

namespace Slayer\Mobile\ViewModel;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\View\Element\Block\ArgumentInterface;

/**
 * Class ExtraInfo
 */
class ExtraInfo implements ArgumentInterface
{
    const USE_AJAX_LOADING = 'slayer_test/settings/use_ajax';

    const SHOW_TITLE = 'slayer_customers/customers_settings/show_title';

    const CUSTOM_TITLE = 'slayer_customers/customers_settings/custom_title';

    /**
     * @var ScopeConfigInterface
     */
    private $scopeConfig;

    /**
     * @param ScopeConfigInterface $scopeConfig
     */
    public function __construct(
        ScopeConfigInterface $scopeConfig
    ) {
        $this->scopeConfig = $scopeConfig;
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
            $this->logger->debug($exception);
        }

        return $result;
    }

    /**
     * @return bool
     */
    public function showTitle()
    {
        $result = false;
        try {
            $result = $this->scopeConfig->isSetFlag(self::SHOW_TITLE);
        } catch (\Exception $exception) {
             $this->logger->debug($exception);
        }

        return $result;
    }

    /**
     * @return string
     */
    public function getCustomTitle()
    {
        $result = '';
        try {
            $result = $this->scopeConfig->getValue(self::CUSTOM_TITLE);
        } catch (\Exception $exception) {
            $this->logger->debug($exception);
        }

        return $result;
    }

    /**
     * @return bool
     */
    public function useAjax()
    {
        $result = false;
        try {
            $result = $this->scopeConfig->isSetFlag(
                self::USE_AJAX_LOADING
            );
        } catch (\Exception $exception) {
//             logger->debug();
        }

        return $result;
    }
}