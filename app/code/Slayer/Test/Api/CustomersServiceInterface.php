<?php

namespace Slayer\Test\Api;

/**
 * Interface CustomersServiceInterface
 */
interface CustomersServiceInterface
{
    /**
     * @return mixed
     */
    public function getCustomersList();

    /**
     * @param int $customerId
     * @return mixed
     */
    public function getCustomerById(int $customerId);

    /**
     * @param Data\CustomerInterface $customer
     * @return mixed
     */
    public function saveOrUpdate(Data\CustomerInterface $customer);

    /**
     * @param int $customerId
     * @return mixed
     */
    public function deleteById(int $customerId);
}