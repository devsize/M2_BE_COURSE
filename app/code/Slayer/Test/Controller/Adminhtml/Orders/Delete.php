<?php

namespace Slayer\Test\Controller\Adminhtml\Orders;

use Magento\Backend\App\Action as BackendAction;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;
use Slayer\Test\Api\Data\OrderInterface;
use Slayer\Test\Api\OrderRepositoryInterface;

/**
 * Class Delete
 */
class Delete extends BackendAction implements HttpGetActionInterface
{
    /**
     * {@inheritdoc}
     */
    const ADMIN_RESOURCE = 'Slayer_Test::order_delete';

    /**
     * @var DataPersistorInterface
     */
    private $dataPersistor;

    /**
     * @var OrderRepositoryInterface
     */
    private $orderRepository;

    /**
     * @param Context $context
     * @param OrderRepositoryInterface $orderRepository
     * @param DataPersistorInterface $dataPersistor
     */
    public function __construct(
        Context $context,
        OrderRepositoryInterface $orderRepository,
        DataPersistorInterface $dataPersistor
    ) {
        $this->dataPersistor = $dataPersistor;
        $this->orderRepository = $orderRepository;
        parent::__construct($context);
    }

    /**
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        $id = (int)$this->getRequest()->getParam(OrderInterface::ENTITY_ID);

        try {
            $this->orderRepository->deleteById($id);
            $this->messageManager->addSuccessMessage(__('You deleted the order'));
            $this->dataPersistor->clear('order');
            return $resultRedirect->setPath('*/*/');
        } catch (NoSuchEntityException $e) {
            $this->messageManager->addErrorMessage($e->getMessage());
        } catch (LocalizedException $e) {
            $this->messageManager->addErrorMessage($e->getMessage());
        } catch (\Exception $e) {
            $this->messageManager->addExceptionMessage($e, __('Something went wrong while deleting the order.'));
        }

        return $resultRedirect->setPath('*/*/');
    }
}