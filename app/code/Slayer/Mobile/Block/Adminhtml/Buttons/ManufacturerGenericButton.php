<?php

namespace Slayer\Mobile\Block\Adminhtml\Buttons;

use Magento\Backend\Block\Widget\Context;
use Magento\Framework\Exception\NoSuchEntityException;
use Slayer\Mobile\Api\ManufacturerRepositoryInterface;
use Slayer\Mobile\Api\Data\ManufacturerInterface;

/**
 * Class ManufacturerGenericButton
 */
class ManufacturerGenericButton
{
    /**
     * @var Context
     */
    protected $context;

    /**
     * @var ManufacturerRepositoryInterface
     */
    private $manufacturerRepository;

    /**
     * @param Context $context
     * @param ManufacturerRepositoryInterface $manufacturerRepository
     */
    public function __construct(
        Context $context,
        ManufacturerRepositoryInterface $manufacturerRepository
    ) {
        $this->context = $context;
        $this->manufacturerRepository = $manufacturerRepository;
    }

    /**
     * @return int|null
     */
    public function getId()
    {
        try {
            $request = $this->context->getRequest();
            $manufacturerId = (int)$request->getParam(ManufacturerInterface::ENTITY_ID);
            return $this->manufacturerRepository->getById($manufacturerId)->getId();
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