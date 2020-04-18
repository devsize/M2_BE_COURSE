<?php

namespace Slayer\Mobile\Block\Adminhtml\Buttons;

use Magento\Framework\View\Element\UiComponent\Control\ButtonProviderInterface;
use Slayer\Mobile\Api\Data\PhoneInterface;

/**
 * Class PhoneDeleteButton
 * @package Slayer\Mobile
 */
class PhoneDeleteButton extends PhoneGenericButton implements ButtonProviderInterface
{
    /**
     * @return array
     */
    public function getButtonData()
    {
        $data = [];
        $phoneId = $this->getPhoneId();
        if ($phoneId) {
            $data = [
                'label' => __('Delete Phone'),
                'class' => 'delete',
                'on_click' => 'deleteConfirm(\'' . __(
                    'Are you sure you want to do this?'
                ) . '\', \'' . $this->getDeleteUrl($phoneId) . '\')',
                'sort_order' => 20,
            ];
        }

        return $data;
    }

    /**
     * @param int|string
     * @return string
     */
    public function getDeleteUrl($phoneId)
    {
        return $this->getUrl('*/*/delete', [PhoneInterface::ENTITY_ID => $phoneId]);
    }
}