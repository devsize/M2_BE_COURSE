<?php

namespace Slayer\Test\Observer;

use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\Message\ManagerInterface;

/**
 * Class MyCustomObserver
 */
class MyCustomObserver implements ObserverInterface
{
    /**
     * @var ManagerInterface
     */
    private $messageManager;

    /**
     * @param ManagerInterface $messageManager
     */
    public function __construct(
        ManagerInterface $messageManager
    ) {
        $this->messageManager = $messageManager;
    }

    /**
     * {@inheritDoc}
     */
    public function execute(Observer $observer)
    {
        $event = $observer->getEvent();
        $request = $event->getRequest();
        $product = $event->getData('product');
        $date = new \DateTime('now');

        /** @var $product \Magento\Catalog\Model\Product */
        $str = $product->getSku();
        $pattern = '/(\w+)-(\w+)-(\w+)/i';
        $replacement = '${2}';
        $size = preg_replace($pattern, $replacement, $str);

        $message = __(
            'You added product "%3" with id "%1" at "%2" with price: "%4"',
            $product->getId(),
            $date->format('F j, Y, g:i a'),
            $product->getName(),
            number_format($product->getPrice(), 2, '.', '')
        );

        if ($size == 'XL') {
            $message = __('Oh, u`re fucking fat! It\'s disgusting :D Lose some weight!');
        } elseif ($size == 'XS') {
            $message = __('You are bony like death! Eat something!');
        }

        $this->messageManager->addSuccessMessage($message);
    }
}