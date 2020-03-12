<?php

namespace Slayer\Test\Block;

use Magento\Framework\Api\SearchCriteria;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\Api\SearchResultsInterface;
use Magento\Framework\Api\SortOrder;
use Magento\Framework\Api\SortOrderBuilder;
use Magento\Framework\App\Request\Http;
use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;
use Slayer\Test\Api\OrderRepositoryInterface;
use Slayer\Test\Api\Data\OrderInterface;

//use Slayer\Test\Model\OrderModel;
//use Slayer\Test\Model\ResourceModel\Order\Collection as OrderCollection;
//use Slayer\Test\Model\ResourceModel\Order\CollectionFactory as OrderCollectionFactory;

/**
 * Class Order
 */
class Order extends Template
{
    /**
//     * @var OrderCollectionFactory
     */
//    private $orderCollectionFactory;

    /**
//     * @var OrderCollection|null
     */
//    private $orderCollection;

    /**
     * @var OrderRepositoryInterface
     */
    private $orderRepository;

    /**
     * @var SearchCriteriaBuilder
     */
    private $searchCriteriaBuilder;

    /**
     * @var SortOrderBuilder
     */
    private $sortOrderBuilder;

    /**
     * @var OrderInterface[]|null
     */
    private $orders;

    /**
     * @param Context $context
//     * @param OrderCollectionFactory $orderCollectionFactory
     * @param OrderRepositoryInterface $orderRepository
     * @param SearchCriteriaBuilder $searchCriteriaBuilder
     * @param SortOrderBuilder $sortOrderBuilder
     * @param array $data
     */
    public function __construct(
        Context $context,
//        OrderCollectionFactory $orderCollectionFactory,
        OrderRepositoryInterface $orderRepository,
        SearchCriteriaBuilder $searchCriteriaBuilder,
        SortOrderBuilder $sortOrderBuilder,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->orderRepository = $orderRepository;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
        $this->sortOrderBuilder = $sortOrderBuilder;
//        $this->orderCollectionFactory = $orderCollectionFactory;
//        if ($orderCollectionFactory instanceof orderCollectionFactory) {
//            echo get_class($orderCollectionFactory) . ' we have virtual type!';
//            die();
//        } else {
//            die('no virtual_type!');
//        }
    }

    /**
//     * @return Template
     */
//    protected function _prepareLayout()
//    {
//        /** @var \Magento\Framework\App\Request\Http $request */
//        $request = $this->getRequest();
//        $userId = (int)$request->getParam(OrderModel::USER_ID);
//        if ($userId > 0 && $this->orderCollection === null) {
//            $this->orderCollection = $this->orderCollectionFactory->create();
//            $this->orderCollection->addFieldToFilter(
//                OrderModel::USER_ID,
//                ['eq' => $userId]
//            );
//        }
//
//        return parent::_prepareLayout();
//    }

//    /**
//     * @return OrderCollection|null
//     */
//    public function getOrderCollection()
//    {
//        return $this->orderCollection;
//    }
    protected function _prepareLayout()
    {
        /** @var Http $request */
        $request = $this->getRequest();
        $userId = (int)$request->getParam(OrderInterface::USER_ID);
        if ($userId > 0 && $this->orders === null) {
            $this->orders = [];
            try {
                /** @var SortOrder $sortOrder */
                $sortOrder = $this->sortOrderBuilder
                    ->setField(OrderInterface::CREATED_AT)
                    ->setDirection(SortOrder::SORT_ASC)
                    ->create();
                /** @var SearchCriteria|SearchCriteriaInterface $searchCriteria */
                $searchCriteria = $this->searchCriteriaBuilder
                    ->addFilter(OrderInterface::USER_ID, $userId)
                    ->addSortOrder($sortOrder)
                    ->create();
                /** @var SearchResultsInterface $searchResults */
                $searchResults = $this->orderRepository->getList($searchCriteria);
                if ($searchResults->getTotalCount() > 0) {
                    $this->orders = $searchResults->getItems();
                }
            } catch (\Exception $exception) {
                $error = $exception->getMessage();
                $text = 'Orders loading has failed: message "%s"';
                $message = sprintf($text, $error);
                $this->_logger->debug($message);
            }
        }

        return parent::_prepareLayout();
    }

    /**
     * @return OrderInterface[]|null
     */
    public function getOrders()
    {
        return $this->orders;
    }
}
