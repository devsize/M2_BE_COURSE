<?php

namespace Slayer\Test\Model\ResourceModel\Customer;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use Slayer\Test\Model\CustomerModel;
use Slayer\Test\Model\ResourceModel\Customer as CustomerResourceModel;

/**
 * Class Collection
 */
class Collection extends AbstractCollection
{
    /**
     * {@inheritDoc}
     */
    protected $_idFieldName = CustomerModel::ENTITY_ID;

    protected function _construct()
    {
        $this->_init(
            CustomerModel::class,
            CustomerResourceModel::class
        );
    }
}
