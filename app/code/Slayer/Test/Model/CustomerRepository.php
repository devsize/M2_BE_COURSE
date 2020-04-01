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
use Slayer\Test\Api\CustomerRepositoryInterface;
use Slayer\Test\Api\Data\CustomerInterface;
use Slayer\Test\Model\CustomerModelFactory;
use Slayer\Test\Model\ResourceModel\Customer\Collection;
use Slayer\Test\Model\ResourceModel\Customer\CollectionFactory as CustomerCollectionFactory;
use Slayer\Test\Model\ResourceModel\Customer as CustomerResource;

/**
 * Class CustomerRepository
 */
class CustomerRepository implements CustomerRepositoryInterface
{
    /**
     * @var CustomerModelFactory
     */
    private $customerFactory;

    /**
     * @var CustomerCollectionFactory
     */
    private $customerCollectionFactory;

    /**
     * @var CustomerResource
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
     * @param CustomerModelFactory $customerFactory
     * @param CustomerCollectionFactory $customerCollectionFactory
     * @param CustomerResource $resource
     * @param SearchResultsInterfaceFactory $searchResultsFactory
     * @param CollectionProcessorInterface $collectionProcessor
     */
    public function __construct(
        CustomerModelFactory $customerFactory,
        CustomerCollectionFactory $customerCollectionFactory,
        CustomerResource $resource,
        SearchResultsInterfaceFactory $searchResultsFactory,
        CollectionProcessorInterface $collectionProcessor
    ) {
        $this->customerFactory = $customerFactory;
        $this->customerCollectionFactory = $customerCollectionFactory;
        $this->resource = $resource;
        $this->searchResultsFactory = $searchResultsFactory;
        $this->collectionProcessor = $collectionProcessor;
    }

    /**
     * {@inheritdoc}
     */
    public function save(CustomerInterface $customer): CustomerInterface
    {
        try {
            /** @var ManufacturerModel|CustomerInterface $customer */
            $this->resource->save($customer);
        } catch (\Exception $exception) {
            throw new CouldNotSaveException(__($exception->getMessage()));
        }

        return $customer;
    }

    /**
     * {@inheritdoc}
     */
    public function getById(int $customerId): CustomerInterface
    {
        /** @var ManufacturerModel|CustomerInterface $customer */
        $customer = $this->customerFactory->create();
        $customer->load($customerId);
        if (!$customer->getId()) {
            throw new NoSuchEntityException(__('Customer entity with id `%1` does not exist.', $customerId));
        }

        return $customer;
    }

    /**
     * {@inheritDoc}
     */
    public function getList(SearchCriteriaInterface $criteria): SearchResults
    {
        /** @var Collection $collection */
        $collection = $this->customerCollectionFactory->create();
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
    public function delete(CustomerInterface $customer): bool
    {
        try {
            /** @var ManufacturerModel $customer */
            $this->resource->delete($customer);
        } catch (\Exception $exception) {
            throw new CouldNotDeleteException(__($exception->getMessage()));
        }

        return true;
    }

    /**
     * {@inheritDoc}
     */
    public function deleteById(int $customerId): bool
    {
        return $this->delete($this->getById($customerId));
    }
}