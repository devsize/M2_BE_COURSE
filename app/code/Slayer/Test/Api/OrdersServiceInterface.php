<?php

namespace Slayer\Test\Api;

/**
 * Interface OrdersServiceInterface
 */
interface OrdersServiceInterface
{
    /**
     * @return mixed
     */
    public function getOrdersList();

    /**
     * @return int $userId
     * @return mixed
     */
    public function getOrdersListByUserId($userId);

//    /**
//     * @return int $userId
//     * @return mixed
//     */
//    public function setOrderIdByUserId($userId);

//    /**
//     * @return int $userId
//     * @return mixed
//     */
//    public function deleteOrdersByUserId($userId);
}
