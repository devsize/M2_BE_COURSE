<?php

namespace Slayer\Test\Controller\Adminhtml\Customers;

use Magento\Backend\App\Action as BackendAction;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\View\Result\PageFactory;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Exception\NoSuchEntityException;
use Slayer\Test\Api\Data\CustomerInterface;
use Slayer\Test\Api\Data\CustomerInterfaceFactory;
use Slayer\Test\Api\CustomerRepositoryInterface;

/**
 * Class Edit
 */
class Edit extends BackendAction implements HttpGetActionInterface
{
    /**
     * {@inheritdoc}
     */
    const ADMIN_RESOURCE = 'Slayer_Test::customer_edit';

    /**
     * @var PageFactory
     */
    private $resultPageFactory;

    /**
     * @var CustomerRepositoryInterface
     */
    private $customerRepository;

    /**
     * @var CustomerInterfaceFactory
     */
    private $customerFactory;

    /**
     * @param Context $context
     * @param CustomerRepositoryInterface $customerRepository
     * @param CustomerInterfaceFactory $customerFactory
     * @param PageFactory $resultPageFactory
     */
    public function __construct(
        Context $context,
        CustomerRepositoryInterface $customerRepository,
        CustomerInterfaceFactory $customerFactory,
        PageFactory $resultPageFactory
    ) {
        $this->customerRepository = $customerRepository;
        $this->customerFactory = $customerFactory;
        $this->resultPageFactory = $resultPageFactory;
        parent::__construct($context);
    }

    /**
     * @return ResultInterface
     */
    public function execute()
    {
        $id = (int)$this->getRequest()->getParam(CustomerInterface::ENTITY_ID);

        if ($id) {
            try {
                $model = $this->customerRepository->getById($id);
            } catch (NoSuchEntityException $e) {
                $this->messageManager->addErrorMessage(__($e->getMessage()));
                /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
                $resultRedirect = $this->resultRedirectFactory->create();
                return $resultRedirect->setPath('*/*/');
            }
        } else {
            $model = $this->customerFactory->create();
        }

        /** @var ResultInterface $resultPage */
        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu('Slayer_Test::slayer_manage_customers');

        $resultPage->getConfig()->getTitle()->prepend(__('Customer'));
        $resultPage->getConfig()->getTitle()->prepend($model->getId() ? $model->getName() : __('New Customer'));
        return $resultPage;
    }
}