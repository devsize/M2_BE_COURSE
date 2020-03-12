<?php

namespace Slayer\Test\Controller\Adminhtml\Customers;

use Magento\Backend\App\Action as BackendAction;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;
use Slayer\Test\Api\Data\CustomerInterface;
use Slayer\Test\Api\CustomerRepositoryInterface;

/**
 * Class Delete
 */
class Delete extends BackendAction implements HttpGetActionInterface
{
    /**
     * {@inheritdoc}
     */
    const ADMIN_RESOURCE = 'Slayer_Test::customer_delete';

    /**
     * @var DataPersistorInterface
     */
    private $dataPersistor;

    /**
     * @var CustomerRepositoryInterface
     */
    private $customerRepository;

    /**
     * @param Context $context
     * @param CustomerRepositoryInterface $customerRepository
     * @param DataPersistorInterface $dataPersistor
     */
    public function __construct(
        Context $context,
        CustomerRepositoryInterface $customerRepository,
        DataPersistorInterface $dataPersistor
    ) {
        $this->dataPersistor = $dataPersistor;
        $this->customerRepository = $customerRepository;
        parent::__construct($context);
    }

    /**
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        $id = (int)$this->getRequest()->getParam(CustomerInterface::ENTITY_ID);

        try {
            $this->customerRepository->deleteById($id);
            $this->messageManager->addSuccessMessage(__('You deleted the customer'));
            $this->dataPersistor->clear('customer');
            return $resultRedirect->setPath('*/*/');
        } catch (NoSuchEntityException $e) {
            $this->messageManager->addErrorMessage($e->getMessage());
        } catch (LocalizedException $e) {
            $this->messageManager->addErrorMessage($e->getMessage());
        } catch (\Exception $e) {
            $this->messageManager->addExceptionMessage($e, __('Something went wrong while deleting the customer.'));
        }

        return $resultRedirect->setPath('*/*/');
    }
}