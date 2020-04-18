<?php

namespace Slayer\Mobile\Block\Adminhtml\Buttons;

use Magento\Framework\View\Element\UiComponent\Control\ButtonProviderInterface;
use Slayer\Mobile\Api\Data\ManufacturerInterface;

/**
 * Class ManufacturerDeleteButton
 */
class ManufacturerDeleteButton extends ManufacturerGenericButton implements ButtonProviderInterface
{
    /**
     * @return array
     */
    public function getButtonData()
    {
        $data = [];
        $manufacturerId = $this->getId();
        if ($manufacturerId) {
            $data = [
                'label' => __('Delete Manufacturer'),
                'class' => 'delete',
                'on_click' => 'deleteConfirm(\'' . __(
                    'Are you sure you want to do this?'
                ) . '\', \'' . $this->getDeleteUrl($manufacturerId) . '\')',
                'sort_order' => 20,
            ];
        }

        return $data;
    }

    /**
     * @param int|string
     * @return string
     */
    public function getDeleteUrl($manufacturerId)
    {
        return $this->getUrl('*/*/delete', [ManufacturerInterface::ENTITY_ID => $manufacturerId]);
    }
}