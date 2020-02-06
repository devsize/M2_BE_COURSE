<?php

namespace Slayer\Test\Model;

use Magento\Framework\Model\AbstractModel;
use Slayer\Test\Api\Data\OrderInterface;
use Slayer\Test\Model\ResourceModel\Order as OrderResourceModel;

/**
 * Class OrderModel
 */
class OrderModel extends AbstractModel implements OrderInterface
{
//    const ENTITY_ID = 'entity_id';
//    const USER_ID = 'user_id';
//    const ORDER_ID = 'order_id';
//    const ORDER_NAME = 'order_name';
//    const CREATED_AT = 'created_at';
//    const PRICE = 'price';

    /**
     * GETTERS
     */

    /**
     * {@inheritdoc}
     */
    public function _construct()
    {
        $this->_init(OrderResourceModel::class);
    }

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->getData(self::ENTITY_ID);
    }

    /**
     * {@inheritdoc}
     */
    public function getUserId()
    {
        return $this->getData(self::USER_ID);
    }

    /**
     * {@inheritdoc}
     */
    public function getOrderId()
    {
        return $this->getData(self::ORDER_ID);
    }

    /**
     * {@inheritdoc}
     */
    public function getOrderName()
    {
        return $this->getData(self::ORDER_NAME);
    }

    /**
     * {@inheritdoc}
     */
    public function getCreatedAt()
    {
        return $this->getData(self::CREATED_AT);
    }

    /**
     * {@inheritdoc}
     */
    public function getPrice()
    {
        return $this->getData(self::PRICE);
    }

    /**
     * SETTERS
     */

    /**
     * {@inheritdoc}
     */
    public function setId($id)
    {
        return $this->setData(self::ENTITY_ID, $id);
    }

    /**
     * {@inheritdoc}
     */
    public function setUserId(int $userId): OrderInterface
    {
        return $this->setData(self::USER_ID, $userId);
    }

    /**
     * {@inheritdoc}
     */
    public function setOrderId(int $orderId): OrderInterface
    {
        return $this->setData(self::ORDER_ID, $orderId);
    }

    /**
     * {@inheritdoc}
     */
    public function setOrderName(string $orderName): OrderInterface
    {
        return $this->setData(self::ORDER_NAME, $orderName);
    }

    /**
     * {@inheritdoc}
     */
    public function setCreatedAt(\DateTime $createdAt): OrderInterface
    {
        return $this->setData(self::CREATED_AT, $createdAt->format('Y-m-d H:i:s'));
    }

    /**
     * {@inheritdoc}
     */
    public function setPrice(float $price): OrderInterface
    {
        return $this->setData(self::PRICE, $price);
    }
}
