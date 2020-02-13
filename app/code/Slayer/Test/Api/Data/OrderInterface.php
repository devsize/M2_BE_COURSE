<?php

namespace Slayer\Test\Api\Data;

/**
 * Interface OrderInterface
 */
interface OrderInterface
{
    const ENTITY_ID = 'entity_id';
    const USER_ID = 'user_id';
    const ORDER_ID = 'order_id';
    const ORDER_NAME = 'order_name';
    const CREATED_AT = 'created_at';
    const PRICE = 'price';

    /**
     * Get entity id
     *
     * @return int
     */
    public function getId();

    /**
     * Get user id
     *
     * @return int
     */
    public function getUserId();

    /**
     * Get order id
     *
     * @return int
     */
    public function getOrderId();

    /**
     * Get order name
     *
     * @return string
     */
    public function getOrderName();

    /**
     * Get created at date
     *
     * @return mixed
     */
    public function getCreatedAt();

    /**
     * Get car price
     *
     * @return float
     */
    public function getPrice();

    /**
     * Set entity id
     *
     * @param int $id
     * @return $this
     */
    public function setId($id);

    /**
     * Set user id
     *
     * @param int $userId
     * @return OrderInterface
     */
    public function setUserId(int $userId): OrderInterface;

    /**
     * Set order id
     *
     * @param int $orderId
     * @return OrderInterface
     */
    public function setOrderId(int $orderId): OrderInterface;

    /**
     * Set order name
     *
     * @param string $orderName
     * @return OrderInterface
     */
    public function setOrderName(string $orderName): OrderInterface;

    /**
     * Set created at date
     *
//      @param \DateTime $createdAt
     * @param string $createdAt
     * @return OrderInterface
     */
    public function setCreatedAt(string $createdAt): OrderInterface;

    /**
     * Set car price
     *
     * @param float $price
     * @return OrderInterface
     */
    public function setPrice(float $price): OrderInterface;
}
