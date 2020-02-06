<?php

namespace Slayer\Test\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;
use Slayer\Test\Model\CustomerModel;

/**
 * Class Customer
 */
class Customer extends AbstractDb
{
    const MY_CUSTOMERS_TABLE = 'my_customers_table';
    /**
     * {@inheritDoc}
     */
    protected function _construct()
    {
         $this->_init(
             self::MY_CUSTOMERS_TABLE,
             CustomerModel::ENTITY_ID
         );
    }
}
