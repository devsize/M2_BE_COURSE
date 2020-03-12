<?php

namespace Slayer\Test\Model;

use Magento\Framework\Api\SearchCriteria;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\Api\SearchResultsInterface;
use Slayer\Test\Api\OrdersServiceInterface;
use Slayer\Test\Api\OrderRepositoryInterface;
use Slayer\Test\Api\Data\OrderInterface;
//use Slayer\Test\Model\OrderModelFactory;

/**
 * Class OrdersService
 */
class OrdersService implements OrdersServiceInterface
{
    /**
     * @var OrderModelFactory
     */
//    private $orderFactory;

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
//     * @param OrderModelFactory $orderFactory
     * @param OrderRepositoryInterface $orderRepository
     * @param SearchCriteriaBuilder $searchCriteriaBuilder
     */
    public function __construct(
        OrderRepositoryInterface $orderRepository,
        SearchCriteriaBuilder $searchCriteriaBuilder//,
//        OrderModelFactory $orderFactory
    ) {
        $this->orderRepository = $orderRepository;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
//        $this->orderFactory = $orderFactory;
    }



    /**
     * @param int|null $userId
     * @return SearchCriteria
     */
    private function getSearchCriteria($userId = null)
    {
        if ($userId > 0) {
            /** @var SearchCriteria $searchCriteria */
            $searchCriteria = $this->searchCriteriaBuilder
                ->addFilter(OrderInterface::USER_ID, $userId)
                ->create();
        } else {
            /** @var SearchCriteria $searchCriteria */
            $searchCriteria = $this->searchCriteriaBuilder->create();
        }

        return $searchCriteria;
    }

    /**
     * @param int|null $userId
     * @return array
     */
    private function composeList($userId = null)
    {
        $resultArray = [];
        try {
            /** @var SearchCriteria $searchCriteria */
            $searchCriteria = $this->getSearchCriteria($userId);
            /** @var SearchResultsInterface $searchResults */
            $searchResults = $this->orderRepository->getList($searchCriteria);
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
        } catch (\Exception $exception) {
            // logging
        }

        return $resultArray;
    }



    /**
     * @inheritdoc
     */
    public function getOrdersList()
    {
//        /** @var  SearchCriteria $searchCriteria */
//        $searchCriteria = $this->searchCriteriaBuilder->create();
//        /** @var  SearchResultsInterface $searchResults */
//        $searchResults = $this->orderRepository->getList($searchCriteria);
//        $resultArray = [];
//        if ($searchResults->getTotalCount() > 0) {
//            foreach ($searchResults->getItems() as $item) {
//                /** @var OrderInterface $item */
//                $resultArray[] = [
//                    'id' => $item->getId(),
//                    'order_id' => $item->getOrderId(),
//                    'user_id' => $item->getUserId(),
//                    'order_name' => $item->getOrderName(),
//                    'created_at' => $item->getCreatedAt(),
//                    'price' => $item->getPrice()
//                ];
//            }
//        }
//        return $resultArray;
        return $this->composeList();
    }

    /**
     * @inheritdoc
     */
    public function getOrdersListByUserId($userId)
    {
        if (empty($userId)) {
//            return false;
            return [];
        }
        return $this->composeList($userId);
//        /** @var  SearchCriteria $searchCriteria */
//        $searchCriteria = $this->searchCriteriaBuilder
//            ->addFilter(OrderInterface::USER_ID, $userId)
//            ->create();
//        /** @var  SearchResultsInterface $searchResults */
//        $searchResults = $this->orderRepository->getList($searchCriteria);
//        $resultArray = [];
//        if ($searchResults->getTotalCount() > 0) {
//            foreach ($searchResults->getItems() as $item) {
//                /** @var OrderInterface $item */
//                $resultArray[] = [
//                    'id' => $item->getId(),
//                    'order_id' => $item->getOrderId(),
//                    'user_id' => $item->getUserId(),
//                    'order_name' => $item->getOrderName(),
//                    'created_at' => $item->getCreatedAt(),
//                    'price' => $item->getPrice()
//                ];
//            }
//        }
//        return $resultArray;
    }
/** These are my functions */
//    /**
//     * @param int $userId
//     * @param int $orderId
//     * @param string $orderName
//     * @param float $price
//     * @return mixed
//     * @throws \Magento\Framework\Exception\CouldNotSaveException
//     */
//    public function setOrder($userId, $orderId, $orderName, $price)
//    {
//            $createdAt = new \DateTime('');
//            /** @var OrderModel|OrderInterface $orderModel */
//            $orderModel = $this->orderFactory->create();
//            /** @var OrderInterface $orderModel */
//            $orderModel->setUserId($userId);
//            $orderModel->setOrderId($orderId);
//            $orderModel->setOrderName($orderName);
//            $orderModel->setCreatedAt($createdAt);
//            $orderModel->setPrice($price);
//            $this->orderRepository->save($orderModel);
//            return  'Your set of order was successful! Order was set!';
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
//
//        $searchResults = $this->orderRepository->getList($searchCriteria);
//        $items = $searchResults->getItems();
//        foreach ($items as &$item) {
//            $item = array_shift($items);
//            $this->orderRepository->delete($item);
//        }
//        return "Your orders by $userId was deleted successfully!";
//    }
/** End of my functions */

    public function save(OrderInterface $order)
//    must be named as public function "saveOrUpdate"(OrderInterface $order)
    {
        try {
            $newOrder = $this->orderRepository->save($order);
            $message = sprintf('success, new order id is: %s', $newOrder->getId());
        } catch (\Exception $exception) {
            $message = sprintf('could not save: %s', $exception->getMessage());
        }
        return $message;
    }

    public function delete(int $orderId)
//    must be named as public function deleteById(int $orderId)
    {
        try {
            $this->orderRepository->deleteById($orderId);
            $message = sprintf('order with id %s was deleted!', $orderId);
        } catch (\Exception $exception) {
            $exceptionMessage = $exception->getMessage();
            $message = sprintf('could not delete order with id: %s; message: %s', $orderId, $exceptionMessage);
        }
        return $message;
    }
}