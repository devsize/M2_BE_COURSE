<?php

namespace Slayer\Mobile\Controller\Adminhtml\Phones;

use Magento\Backend\App\Action as BackendAction;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;
use Slayer\Mobile\Api\Data\PhoneInterface;
use Slayer\Mobile\Api\PhoneRepositoryInterface;
use Magento\Framework\Controller\ResultInterface;
use Magento\Backend\Model\View\Result\Redirect;

/**
 * Class Delete
 */
class Delete extends BackendAction implements HttpGetActionInterface
{
    /**
     * {@inheritdoc}
     */
    const ADMIN_RESOURCE = 'Slayer_Mobile::phone_delete';

    /**
     * @var DataPersistorInterface
     */
    private $dataPersistor;

    /**
     * @var PhoneRepositoryInterface
     */
    private $phoneRepository;

    /**
     * @param Context $context
     * @param PhoneRepositoryInterface $phoneRepository
     * @param DataPersistorInterface $dataPersistor
     */
    public function __construct(
        Context $context,
        PhoneRepositoryInterface $phoneRepository,
        DataPersistorInterface $dataPersistor
    ) {
        $this->dataPersistor = $dataPersistor;
        $this->phoneRepository = $phoneRepository;
        parent::__construct($context);
    }

    /**
     * @return ResultInterface
     */
    public function execute()
    {
        /** @var Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        $id = (int)$this->getRequest()->getParam(PhoneInterface::ENTITY_ID);

        try {
            $this->phoneRepository->deleteById($id);
            $this->messageManager->addSuccessMessage(__('You deleted the phone'));
            $this->dataPersistor->clear('phone');
            return $resultRedirect->setPath('*/*/');
        } catch (NoSuchEntityException $e) {
            $this->messageManager->addErrorMessage($e->getMessage());
        } catch (LocalizedException $e) {
            $this->messageManager->addErrorMessage($e->getMessage());
        } catch (\Exception $e) {
            $this->messageManager->addExceptionMessage($e, __('Something went wrong while deleting the phone.'));
        }

        return $resultRedirect->setPath('*/*/');
    }
}