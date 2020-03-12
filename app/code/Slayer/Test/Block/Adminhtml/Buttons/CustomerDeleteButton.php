<?php

namespace Slayer\Test\Block\Adminhtml\Buttons;

use Magento\Framework\View\Element\UiComponent\Control\ButtonProviderInterface;
use Slayer\Test\Api\Data\CustomerInterface;

/**
 * Class CustomerDeleteButton
 */
class CustomerDeleteButton extends CustomerGenericButton implements ButtonProviderInterface
{
    /**
     * @return array
     */
    public function getButtonData()
    {
        $data = [];
        $customerId = $this->getId();
        if ($customerId) {
            $data = [
                'label' => __('Delete Customer'),
                'class' => 'delete',
                'on_click' => 'deleteConfirm(\'' . __(
                    'Are you sure you want to do this?'
                ) . '\', \'' . $this->getDeleteUrl($customerId) . '\')',
                'sort_order' => 20,
            ];
        }

        return $data;
    }

    /**
     * @param int|string
     * @return string
     */
    public function getDeleteUrl($customerId)
    {
        return $this->getUrl('*/*/delete', [CustomerInterface::ENTITY_ID => $customerId]);
    }
}