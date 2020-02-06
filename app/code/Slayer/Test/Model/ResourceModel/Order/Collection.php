<?php

namespace Slayer\Test\Model\ResourceModel\Order;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use Slayer\Test\Model\OrderModel;
use Slayer\Test\Model\ResourceModel\Order as OrderResourceModel;

/**
 * Class Collection
 */
class Collection extends AbstractCollection
{
    /**
     * {@inheritDoc}
     */
    protected $_idFieldName = OrderModel::ENTITY_ID;

    protected function _construct()
    {
        $this->_init(
            OrderModel::class,
            OrderResourceModel::class
        );
    }
}
