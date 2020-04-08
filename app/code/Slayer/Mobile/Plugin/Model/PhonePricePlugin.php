<?php

namespace Slayer\Mobile\Plugin\Model;

use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\View\Element\Template;
use Magento\Directory\Model\Currency;
use Magento\Directory\Model\CurrencyFactory;
use Magento\Framework\Exception\NoSuchEntityException;
use Slayer\Mobile\Api\Data\PhoneInterface;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Backend\Block\Template\Context;

class PhonePricePlugin extends Template
{

    protected $_storeManager;
    protected $_currency;

    /**
     * @var CurrencyFactory
     */
    protected $currencyFactory;

    /**
     *
     * @param Context $context
     * @param Currency $currency
     * @param CurrencyFactory $currencyFactory
     * @param StoreManagerInterface $storeManager
     * @param array $data
     */
    public function __construct(
        Context $context,
        Currency $currency,
        CurrencyFactory $currencyFactory,
        StoreManagerInterface $storeManager,
        array $data = []
    ) {
        $this->_currency = $currency;
        $this->_storeManager = $storeManager;
        $this->currencyFactory = $currencyFactory;
        parent::__construct($context, $data);
    }

    /**
     * @param $amountValue
     * @return float|int
     * @throws LocalizedException
     */
    private function convertPrice($amountValue)
    {
        $currentCurrency = $this->_storeManager->getStore()->getCurrentCurrencyCode();
        $baseCurrency = $this->_storeManager->getStore()->getBaseCurrency()->getCode();
        try {
            if (($currentCurrency && $baseCurrency) != null) {
                if ($currentCurrency != $baseCurrency) {
                    $rate = $this->_storeManager->getStore()->getCurrentCurrencyRate();
                    $amountValue = $amountValue * $rate;
                }
            }
        } catch (\Exception $e) {
            $error = $e->getMessage();
            $text = 'Error happened during currency loading."%s"';
            $message = sprintf($text, $error);
            $this->_logger->debug($message);
            throw new LocalizedException(__($message));
        }
        return $amountValue;
    }

    /**
     * @param PhoneInterface $subject
     * @param $result
     * @throws LocalizedException
     */
    public function afterGetPrice(PhoneInterface $subject, $result)
    {
        try {
            if (is_numeric($result)) {
                $result = round($this->convertPrice($result), 2);
                $currencySymbol = $this->_currency->getCurrencySymbol();
            }
        } catch (\Exception $e) {
            throw new LocalizedException(__($e->getMessage()));
        }
        echo "$result <b class=\"currency\"> &nbsp;$currencySymbol</b>";
    }
}