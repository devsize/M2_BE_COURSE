<?php

namespace Slayer\Test\Model\Config\Source;

class Checkbox implements \Magento\Framework\Option\ArrayInterface
{

    /**
     * Options getter
     *
     * @return array
     *
     */
    public function toOptionArray()
    {
        return [
            ['value' => '1', 'label'=>__('Yes')],
            ['value' => '0', 'label'=>__('No')]
        ];
    }
}