<?php

namespace Slayer\Mobile\Block\Adminhtml\Buttons;

use Magento\Backend\Block\Widget\Context;
use Magento\Framework\Exception\NoSuchEntityException;
use Slayer\Mobile\Api\PhoneRepositoryInterface;
use Slayer\Mobile\Api\Data\PhoneInterface;

/**
 * Class PhoneGenericButton
 */
class PhoneGenericButton
{
    /**
     * @var Context
     */
    protected $context;

    /**
     * @var PhoneRepositoryInterface
     */
    private $phoneRepository;

    /**
     * @param Context $context
     * @param PhoneRepositoryInterface $phoneRepository
     */
    public function __construct(
        Context $context,
        PhoneRepositoryInterface $phoneRepository
    ) {
        $this->context = $context;
        $this->phoneRepository = $phoneRepository;
    }

    /**
     * @return int|null
     */
    public function getPhoneId()
    {
        try {
            $request = $this->context->getRequest();
            $phoneId = (int)$request->getParam(PhoneInterface::ENTITY_ID);
            return $this->phoneRepository->getById($phoneId)->getId();
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