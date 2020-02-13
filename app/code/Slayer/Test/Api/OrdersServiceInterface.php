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
     * @param int $userId
     * @return mixed
     */
    public function getOrdersListByUserId($userId);

//    /**
//     * @param int $userId
//     * @param int $orderId
//     * @param string $orderName
//     * @param float $price
//     * @return mixed
//     */
//    public function setOrder($userId, $orderId, $orderName, $price);
//
//    /**
//     * @param int $userId
//     * @return mixed
//     */
//    public function deleteOrdersByUserId($userId);
    /**
     * @param Data\OrderInterface $order
     * @return mixed
     */
    public function save(Data\OrderInterface $order);

    /**
     * @param int $orderId
     * @return mixed
     */
    public function delete(int $orderId);

}
