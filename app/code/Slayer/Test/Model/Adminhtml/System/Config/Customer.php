<?php
namespace Slayer\Test\Model\Adminhtml\System\Config;

use Slayer\Test\Model\ResourceModel\Customer\Collection;
use Magento\Framework\Option\ArrayInterface;

/**
 * Class Customer
 */
class Customer implements ArrayInterface
{
    /**
     * @var array
     */
    protected $options;

    /**
     * Customers
     *
     * @var Collection
     */
    protected $customersCollection;

    /**
     * @param Collection $customersCollection
     */
    public function __construct(Collection $customersCollection)
    {
        $this->customersCollection = $customersCollection;
    }

    /**
     * @param bool $isMultiselect
     * @return array
     */
    public function toOptionArray($isMultiselect = false)
    {
        if (!$this->options) {
            $this->options = $this->customersCollection
                ->addFieldToFilter('customer_id')
                ->loadData()
                ->toOptionArray(false);
        }

        $options = $this->options;
        if (!$isMultiselect) {
            array_unshift($options, ['value' => '', 'label' => __('--Please Select--')]);
        }

        return $options;
    }
}
