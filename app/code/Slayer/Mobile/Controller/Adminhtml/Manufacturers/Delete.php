<?php

namespace Slayer\Mobile\Controller\Adminhtml\Manufacturers;

use Magento\Backend\App\Action as BackendAction;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;
use Slayer\Mobile\Api\Data\ManufacturerInterface;
use Slayer\Mobile\Api\ManufacturerRepositoryInterface;
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
    const ADMIN_RESOURCE = 'Slayer_Mobile::manufacturer_delete';

    /**
     * @var DataPersistorInterface
     */
    private $dataPersistor;

    /**
     * @var ManufacturerRepositoryInterface
     */
    private $manufacturerRepository;

    /**
     * @param Context $context
     * @param ManufacturerRepositoryInterface $manufacturerRepository
     * @param DataPersistorInterface $dataPersistor
     */
    public function __construct(
        Context $context,
        ManufacturerRepositoryInterface $manufacturerRepository,
        DataPersistorInterface $dataPersistor
    ) {
        $this->dataPersistor = $dataPersistor;
        $this->manufacturerRepository = $manufacturerRepository;
        parent::__construct($context);
    }

    /**
     * @return ResultInterface
     */
    public function execute()
    {
        /** @var Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        $id = (int)$this->getRequest()->getParam(ManufacturerInterface::ENTITY_ID);

        try {
            $this->manufacturerRepository->deleteById($id);
            $this->messageManager->addSuccessMessage(__('You deleted the manufacturer'));
            $this->dataPersistor->clear('manufacturer');
            return $resultRedirect->setPath('*/*/');
        } catch (NoSuchEntityException $e) {
            $this->messageManager->addErrorMessage($e->getMessage());
        } catch (LocalizedException $e) {
            $this->messageManager->addErrorMessage($e->getMessage());
        } catch (\Exception $e) {
            $this->messageManager->addExceptionMessage($e, __('Something went wrong while deleting the manufacturer.'));
        }

        return $resultRedirect->setPath('*/*/');
    }
}