<?php

namespace Slayer\Test\Api;

use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Api\SearchResults;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;
use Slayer\Test\Api\Data\CustomerInterface;

/**
 * Interface CustomerRepositoryInterface
 */
interface CustomerRepositoryInterface
{
    /**
     * Save Customer entity
     *
     * @param CustomerInterface $customer
     * @return CustomerInterface
     * @throws CouldNotSaveException
     */
    public function save(CustomerInterface $customer): CustomerInterface;

    /**
     * Get Customer by its id
     *
     * @param int $customerId
     * @return CustomerInterface
     * @throws NoSuchEntityException
     */
    public function getById(int $customerId): CustomerInterface;

    /**
     * Get Customer entities list
     *
     * @param SearchCriteriaInterface $searchCriteria
     * @return SearchResults
     * @throws LocalizedException
     */
    public function getList(SearchCriteriaInterface $searchCriteria): SearchResults;

    /**
     * Delete Customer entity
     *
     * @param CustomerInterface $customer
     * @return bool true on success
     * @throws LocalizedException
     */
    public function delete(CustomerInterface $customer): bool;

    /**
     * Delete Customer entity by id
     *
     * @param int $customerId
     * @return bool true on success
     * @throws NoSuchEntityException
     * @throws LocalizedException
     */
    public function deleteById(int $customerId): bool;
}
