<?php

namespace Slayer\Test\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;
use Slayer\Test\Model\OrderModel;

/**
 * Class Order
 */
class Order extends AbstractDb
{
    const MY_ORDERS_TABLE = 'my_orders_table';
    /**
     * {@inheritDoc}
     */
    protected function _construct()
    {
        $this->_init(
            self::MY_ORDERS_TABLE,
            OrderModel::ENTITY_ID
        );
    }
}
