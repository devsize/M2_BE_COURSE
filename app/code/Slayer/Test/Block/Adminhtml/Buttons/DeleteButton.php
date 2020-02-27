<?php

namespace Slayer\Test\Block\Adminhtml\Buttons;

use Magento\Framework\View\Element\UiComponent\Control\ButtonProviderInterface;
use Slayer\Test\Api\Data\OrderInterface;

/**
 * Class DeleteButton
 * @package Slayer\Test
 */
class DeleteButton extends GenericButton implements ButtonProviderInterface
{
    /**
     * @return array
     */
    public function getButtonData()
    {
        $data = [];
        $orderId = $this->getOrderId();
        if ($orderId) {
            $data = [
                'label' => __('Delete Order'),
                'class' => 'delete',
                'on_click' => 'deleteConfirm(\'' . __(
                    'Are you sure you want to do this?'
                ) . '\', \'' . $this->getDeleteUrl($orderId) . '\')',
                'sort_order' => 20,
            ];
        }

        return $data;
    }

    /**
     * @param int|string
     * @return string
     */
    public function getDeleteUrl($orderId)
    {
        return $this->getUrl('*/*/delete', [OrderInterface::ENTITY_ID => $orderId]);
    }
}