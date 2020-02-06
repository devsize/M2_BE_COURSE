<?php


namespace Slayer\Test\Api;

use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Api\SearchResults;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;
use Slayer\Test\Api\Data\OrderInterface;

/**
 * Interface OrderRepositoryInterface
 */
interface OrderRepositoryInterface
{
    /**
     * Save Order entity
     *
     * @param OrderInterface $order
     * @return OrderInterface
     * @throws CouldNotSaveException
     */
    public function save(OrderInterface $order): OrderInterface;

    /**
     * Get Order by its id
     *
     * @param int $orderId
     * @return OrderInterface
     * @throws NoSuchEntityException
     */
    public function getById(int $orderId): OrderInterface;

    /**
     * Get Order entities list
     *
     * @param SearchCriteriaInterface $searchCriteria
     * @return SearchResults
     * @throws LocalizedException
     */
    public function getList(SearchCriteriaInterface $searchCriteria): SearchResults;

    /**
     * Delete Order entity
     *
     * @param OrderInterface $order
     * @return bool true on success
     * @throws LocalizedException
     */
    public function delete(OrderInterface $order): bool;

    /**
     * Delete Order entity by id
     *
     * @param int $orderId
     * @return bool true on success
     * @throws NoSuchEntityException
     * @throws LocalizedException
     */
    public function deleteById(int $orderId): bool;
}
