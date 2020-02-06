<?php

namespace Slayer\Test\Model;

use Magento\Framework\Api\SearchResults;
use Magento\Framework\Api\SearchResultsInterface;
use Magento\Framework\Api\SearchResultsInterfaceFactory;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;
use Slayer\Test\Api\OrderRepositoryInterface;
use Slayer\Test\Api\Data\OrderInterface;
use Slayer\Test\Model\OrderModelFactory;
use Slayer\Test\Model\ResourceModel\Order\Collection;
use Slayer\Test\Model\ResourceModel\Order\CollectionFactory as OrderCollectionFactory;
use Slayer\Test\Model\ResourceModel\Order;

/**
 * Class OrderRepository
 */
class OrderRepository implements OrderRepositoryInterface
{
    /**
     * @var OrderModelFactory
     */
    private $orderFactory;

    /**
     * @var OrderCollectionFactory
     */
    private $orderCollectionFactory;

    /**
     * @var OrderResource
     */
    private $resource;

    /**
     * @type SearchResultsInterfaceFactory
     */
    private $searchResultsFactory;

    /**
     * @type CollectionProcessorInterface
     */
    private $collectionProcessor;

    /**
     * @param OrderModelFactory $orderFactory
     * @param OrderCollectionFactory $orderCollectionFactory
     * @param OrderResource $resource
     * @param SearchResultsInterfaceFactory $searchResultsFactory
     * @param CollectionProcessorInterface $collectionProcessor
     */
    public function __construct(
        OrderModelFactory $orderFactory,
        OrderCollectionFactory $orderCollectionFactory,
        OrderResource $resource,
        SearchResultsInterfaceFactory $searchResultsFactory,
        CollectionProcessorInterface $collectionProcessor
    ) {
        $this->orderFactory = $orderFactory;
        $this->orderCollectionFactory = $orderCollectionFactory;
        $this->resource = $resource;
        $this->searchResultsFactory = $searchResultsFactory;
        $this->collectionProcessor = $collectionProcessor;
    }

    /**
     * {@inheritdoc}
     */
    public function save(OrderInterface $order): OrderInterface
    {
        try {
            /** @var OrderModel|OrderInterface $order */
            $this->resource->save($order);
        } catch (\Exception $exception) {
            throw new CouldNotSaveException(__($exception->getMessage()));
        }

        return $order;
    }

    /**
     * {@inheritdoc}
     */
    public function getById(int $orderId): OrderInterface
    {
        /** @var OrderModel|OrderInterface $order */
        $order = $this->orderFactory->create();
        $order->load($orderId);
        if (!$order->getId()) {
            throw new NoSuchEntityException(__('Order entity with id `%1` does not exist.', $orderId));
        }

        return $order;
    }

    /**
     * {@inheritDoc}
     */
    public function getList(SearchCriteriaInterface $criteria): SearchResults
    {
        /** @var Collection $collection */
        $collection = $this->orderCollectionFactory->create();
        $this->collectionProcessor->process($criteria, $collection);

        /** @var SearchResults $searchResults */
        $searchResults = $this->searchResultsFactory->create();
        $searchResults->setSearchCriteria($criteria);
        $searchResults->setItems($collection->getItems());
        $searchResults->setTotalCount($collection->getSize());
        return $searchResults;
    }

    /**
     * {@inheritDoc}
     */
    public function delete(OrderInterface $order): bool
    {
        try {
            /** @var OrderModel $order */
            $this->resource->delete($order);
        } catch (\Exception $exception) {
            throw new CouldNotDeleteException(__($exception->getMessage()));
        }

        return true;
    }

    /**
     * {@inheritDoc}
     */
    public function deleteById(int $orderId): bool
    {
        return $this->delete($this->getById($orderId));
    }
}