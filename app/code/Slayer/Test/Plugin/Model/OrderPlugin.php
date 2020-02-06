<?php

namespace Slayer\Test\Plugin\Model;

use Slayer\Test\Api\Data\OrderInterface;

class OrderPlugin
{
    /**
     * @param OrderInterface $subject
     * @return array
     */
    public function beforeGetOrderName(OrderInterface $subject)
    {
        echo "\r\n" . '<span class="order_plugin">Before Get OrderName</span>' . "\r\n";
        return [];
    }
     /* @param OrderInterface $subject
     * @param string $result
     * @return string
     */
    public function afterGetOrderName(OrderInterface $subject, $result)
    {
        echo $result . "\r\n" . '<span class="order_plugin">After Get OrderName</span>' . "\r\n";
    }
}