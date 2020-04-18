<?php

namespace Slayer\Mobile\Controller\Adminhtml\Manufacturers;

use Magento\Backend\App\Action as BackendAction;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\View\Result\PageFactory;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Exception\NoSuchEntityException;
use Slayer\Mobile\Api\Data\ManufacturerInterface;
use Slayer\Mobile\Api\Data\ManufacturerInterfaceFactory;
use Slayer\Mobile\Api\ManufacturerRepositoryInterface;
use Magento\Backend\Model\View\Result\Redirect;

/**
 * Class Edit
 */
class Edit extends BackendAction implements HttpGetActionInterface
{
    /**
     * {@inheritdoc}
     */
    const ADMIN_RESOURCE = 'Slayer_Mobile::manufacturer_edit';

    /**
     * @var PageFactory
     */
    private $resultPageFactory;

    /**
     * @var ManufacturerRepositoryInterface
     */
    private $manufacturerRepository;

    /**
     * @var ManufacturerInterfaceFactory
     */
    private $manufacturerFactory;

    /**
     * @param Context $context
     * @param ManufacturerRepositoryInterface $manufacturerRepository
     * @param ManufacturerInterfaceFactory $manufacturerFactory
     * @param PageFactory $resultPageFactory
     */
    public function __construct(
        Context $context,
        ManufacturerRepositoryInterface $manufacturerRepository,
        ManufacturerInterfaceFactory $manufacturerFactory,
        PageFactory $resultPageFactory
    ) {
        $this->manufacturerRepository = $manufacturerRepository;
        $this->manufacturerFactory = $manufacturerFactory;
        $this->resultPageFactory = $resultPageFactory;
        parent::__construct($context);
    }

    /**
     * @return ResultInterface
     */
    public function execute()
    {
        $id = (int)$this->getRequest()->getParam(ManufacturerInterface::ENTITY_ID);

        if ($id) {
            try {
                $model = $this->manufacturerRepository->getById($id);
            } catch (NoSuchEntityException $e) {
                $this->messageManager->addErrorMessage(__($e->getMessage()));
                /** @var Redirect $resultRedirect */
                $resultRedirect = $this->resultRedirectFactory->create();
                return $resultRedirect->setPath('*/*/');
            }
        } else {
            $model = $this->manufacturerFactory->create();
        }

        /** @var ResultInterface $resultPage */
        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu('Slayer_Mobile::manage_manufacturers');

        $resultPage->getConfig()->getTitle()->prepend(__('Manufacturer'));
        $resultPage->getConfig()->getTitle()->prepend($model->getId() ? $model->getName() : __('New Manufacturer'));
        return $resultPage;
    }
}