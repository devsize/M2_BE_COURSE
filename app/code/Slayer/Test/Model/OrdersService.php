<?php

namespace Slayer\Test\Model;

use Magento\Framework\Api\SearchCriteria;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\Api\SearchResultsInterface;
use Slayer\Test\Api\OrdersServiceInterface;
use Slayer\Test\Api\OrderRepositoryInterface;
use Slayer\Test\Api\Data\OrderInterface;

/**
 * Class OrdersService
 */
class OrdersService implements OrdersServiceInterface
{
    /**
     *
     * @var OrderRepositoryInterface
     */
    private $orderRepository;

    /**
     *
     * @var SearchCriteriaBuilder
     */
    private $searchCriteriaBuilder;

    /**
     * @param OrderRepositoryInterface $orderRepository
     * @param SearchCriteriaBuilder $searchCriteriaBuilder
     */
    public function __construct(
        OrderRepositoryInterface $orderRepository,
        SearchCriteriaBuilder $searchCriteriaBuilder
    ) {
        $this->orderRepository = $orderRepository;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
    }

    /**
     * @inheritdoc
     */
    public function getOrdersList()
    {
        /** @var  SearchCriteria $searchCriteria */
        $searchCriteria = $this->searchCriteriaBuilder->create();
        /** @var  SearchResultsInterface $searchResults */
        $searchResults = $this->orderRepository->getList($searchCriteria);
        $resultArray = [];
        if ($searchResults->getTotalCount() > 0) {
            foreach ($searchResults->getItems() as $item) {
                /** @var OrderInterface $item */
                $resultArray[] = [
                    'id' => $item->getId(),
                    'order_id' => $item->getOrderId(),
                    'user_id' => $item->getUserId(),
                    'order_name' => $item->getOrderName(),
                    'created_at' => $item->getCreatedAt(),
                    'price' => $item->getPrice()
                ];
            }
        }
        return $resultArray;
    }

    /**
     * @inheritdoc
     */
    public function getOrdersListByUserId($userId)
    {
        if (empty($userId)) {
            return false;
        }
        /** @var  SearchCriteria $searchCriteria */
        $searchCriteria = $this->searchCriteriaBuilder
            ->addFilter(OrderInterface::USER_ID, $userId)
            ->create();
        /** @var  SearchResultsInterface $searchResults */
        $searchResults = $this->orderRepository->getList($searchCriteria);
        $resultArray = [];
        if ($searchResults->getTotalCount() > 0) {
            foreach ($searchResults->getItems() as $item) {
                /** @var OrderInterface $item */
                $resultArray[] = [
                    'id' => $item->getId(),
                    'order_id' => $item->getOrderId(),
                    'user_id' => $item->getUserId(),
                    'order_name' => $item->getOrderName(),
                    'created_at' => $item->getCreatedAt(),
                    'price' => $item->getPrice()
                ];
            }
        }
        return $resultArray;
    }

//    /**
//     * @inheritdoc
//     */
//    public function setOrderIdByUserId($userId)
//    {
//        if (empty($userId)) {
//            return false;
//        }
//        /** @var  SearchCriteria $searchCriteria */
//        $searchCriteria = $this->searchCriteriaBuilder
//            ->addFilter(OrderInterface::USER_ID, $userId)
//            ->create();
//        /** @var  SearchResultsInterface $searchResults */
//        $searchResults = $this->orderRepository->getList($searchCriteria);
//        $resultArray = $searchResults;
//        foreach ($resultArray as $item) {
//            /** @var OrderInterface $item */
//            $resultArray[] = [
//                'id' => $item->setId(OrderInterface::ENTITY_ID),
//                'user_id' => $item->setUserId(OrderInterface::USER_ID),
//                'order_id' => $item->setOrderId(OrderInterface::ORDER_ID),
//                'order_name' => $item->setOrderName(OrderInterface::ORDER_NAME),
//                'created_at' => $item->setCreatedAt(OrderInterface::CREATED_AT),
//                'price' => $item->setPrice(OrderInterface::PRICE)
//            ];
//        }
//
//        return $resultArray;
//    }
//
//    /**
//     * @inheritdoc
//     */
//    public function deleteOrdersByUserId($userId)
//    {
//        if (empty($userId)) {
//            return false;
//        }
//        /** @var  SearchCriteria $searchCriteria */
//        $searchCriteria = $this->searchCriteriaBuilder
//            ->addFilter(OrderInterface::USER_ID, $userId)
//            ->create();
//        /** @var  SearchResultsInterface $searchResults */
//        $searchResults = $this->orderRepository->getList($searchCriteria);
//        $resultArray = $searchResults;
//        if ($resultArray->getTotalCount() > 0) {
//            foreach ($resultArray as $order) {
//                /** @var OrderRepositoryInterface $order */
//                $order->deleteById(OrderInterface::ORDER_ID);
//            }
//        }
//
//        return $resultArray;
//    }
}