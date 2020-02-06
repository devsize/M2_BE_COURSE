<?php

namespace Slayer\Test\Block;

use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;
use Slayer\Test\Model\OrderModel;
use Slayer\Test\Model\ResourceModel\Order\Collection as OrderCollection;
use Slayer\Test\Model\ResourceModel\Order\CollectionFactory as OrderCollectionFactory;

/**
 * Class Order
 */
class Order extends Template
{
    /**
     * @var OrderCollectionFactory
     */
    private $orderCollectionFactory;

    /**
     * @var OrderCollection|null
     */
    private $orderCollection;

    /**
     * @param Context $context
     * @param OrderCollectionFactory $orderCollectionFactory
     * @param array $data
     */
    public function __construct(
        Context $context,
        OrderCollectionFactory $orderCollectionFactory,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->orderCollectionFactory = $orderCollectionFactory;
//        if ($orderCollectionFactory instanceof orderCollectionFactory) {
//            echo get_class($orderCollectionFactory) . ' we have virtual type!';
//            die();
//        } else {
//            die('no virtual_type!');
//        }
    }

    /**
     * @return Template
     */
    protected function _prepareLayout()
    {
        /** @var \Magento\Framework\App\Request\Http $request */
        $request = $this->getRequest();
        $userId = (int)$request->getParam(OrderModel::USER_ID);
        if ($userId > 0 && $this->orderCollection === null) {
            $this->orderCollection = $this->orderCollectionFactory->create();
            $this->orderCollection->addFieldToFilter(
                OrderModel::USER_ID,
                ['eq' => $userId]
            );
        }

        return parent::_prepareLayout();
    }

    /**
     * @return OrderCollection|null
     */
    public function getOrderCollection()
    {
        return $this->orderCollection;
    }
}
