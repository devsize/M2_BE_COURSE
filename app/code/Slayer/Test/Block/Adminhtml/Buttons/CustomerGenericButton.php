<?php

namespace Slayer\Test\Block\Adminhtml\Buttons;

use Magento\Backend\Block\Widget\Context;
use Magento\Framework\Exception\NoSuchEntityException;
use Slayer\Test\Api\CustomerRepositoryInterface;
use Slayer\Test\Api\Data\CustomerInterface;

/**
 * Class CustomerGenericButton
 */
class CustomerGenericButton
{
    /**
     * @var Context
     */
    protected $context;

    /**
     * @var CustomerRepositoryInterface
     */
    private $customerRepository;

    /**
     * @param Context $context
     * @param CustomerRepositoryInterface $customerRepository
     */
    public function __construct(
        Context $context,
        CustomerRepositoryInterface $customerRepository
    ) {
        $this->context = $context;
        $this->customerRepository = $customerRepository;
    }

    /**
     * @return int|null
     */
    public function getId()
    {
        try {
            $request = $this->context->getRequest();
            $customerId = (int)$request->getParam(CustomerInterface::ENTITY_ID);
            return $this->customerRepository->getById($customerId)->getId();
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