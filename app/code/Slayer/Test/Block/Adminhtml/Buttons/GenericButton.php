<?php

namespace Slayer\Test\Block\Adminhtml\Buttons;

use Magento\Backend\Block\Widget\Context;
use Magento\Framework\Exception\NoSuchEntityException;
use Slayer\Test\Api\OrderRepositoryInterface;
use Slayer\Test\Api\Data\OrderInterface;

/**
 * Class GenericButton
 */
class GenericButton
{
    /**
     * @var Context
     */
    protected $context;

    /**
     * @var OrderRepositoryInterface
     */
    private $orderRepository;

    /**
     * @param Context $context
     * @param OrderRepositoryInterface $orderRepository
     */
    public function __construct(
        Context $context,
        OrderRepositoryInterface $orderRepository
    ) {
        $this->context = $context;
        $this->orderRepository = $orderRepository;
    }

    /**
     * @return int|null
     */
    public function getOrderId()
    {
        try {
            $request = $this->context->getRequest();
            $orderId = (int)$request->getParam(OrderInterface::ENTITY_ID);
            return $this->orderRepository->getById($orderId)->getId();
        } catch (NoSuchEntityException $e) {
            return null;
        }
    }

    /**
     * Generate url by route and parameters
     *
     * @param string $route
     * @param array $params
     * @return  string
     */
    public function getUrl($route = '', $params = [])
    {
        return $this->context->getUrlBuilder()->getUrl($route, $params);
    }
}