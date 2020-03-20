<?php
namespace Slayer\Test\Model\Config\Source;

class Checkbox implements \Magento\Framework\Option\ArrayInterface
{
    public function toOptionArray()
    {
        return [
            ['value' => 'INDEX,FOLLOW', 'label' => 'INDEX, FOLLOW'],
        ];
    }
}