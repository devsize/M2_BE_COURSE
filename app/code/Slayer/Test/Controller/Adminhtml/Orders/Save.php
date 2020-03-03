<?php

namespace Slayer\Test\Controller\Adminhtml\Orders;

use Magento\Backend\App\Action as BackendAction;
use Magento\Backend\App\Action\Context;
use Magento\Backend\Model\View\Result\Redirect;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Framework\App\Request\Http as HttpRequest;
//use Magento\Catalog\Model\ImageUploader;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Controller\ResultInterface;
use Slayer\Test\Api\CustomerRepositoryInterface;
use Slayer\Test\Api\Data\CustomerInterface;
use Slayer\Test\Api\Data\OrderInterface;
use Slayer\Test\Api\Data\OrderInterfaceFactory;
use Slayer\Test\Api\OrderRepositoryInterface;
use Slayer\Test\Model\OrderModel;

/**
 * Class Save
 */
class Save extends BackendAction implements HttpPostActionInterface
{
    /**
     * {@inheritdoc}
     */
    const ADMIN_RESOURCE = 'Slayer_Test::order_save';

    /**
     * @var DataPersistorInterface
     */
    private $dataPersistor;

    /**
     * @var OrderRepositoryInterface
     */
    private $orderRepository;

    /**
     * @var CustomerRepositoryInterface
     */
    private $customerRepository;

    /**
     * @var OrderInterfaceFactory
     */
    private $orderFactory;
//
//    /**
//     * @var ImageUploader
//     */
//    private $imageUploader;

    /**
     * @param Context $context
     * @param OrderRepositoryInterface $orderRepository
     * @param CustomerRepositoryInterface $customerRepository
     * @param OrderInterfaceFactory $orderFactory
     * @param DataPersistorInterface $dataPersistor
    //     * @param ImageUploader $imageUploader
     */
    public function __construct(
        Context $context,
        OrderRepositoryInterface $orderRepository,
        CustomerRepositoryInterface $customerRepository,
        OrderInterfaceFactory $orderFactory,
        DataPersistorInterface $dataPersistor
//        ImageUploader $imageUploader
    ) {
        $this->dataPersistor = $dataPersistor;
        $this->orderRepository = $orderRepository;
        $this->customerRepository = $customerRepository;
        $this->orderFactory = $orderFactory;
//        $this->imageUploader = $imageUploader;
        parent::__construct($context);
    }

    /**
     * @return ResultInterface
     */
    public function execute()
    {
        /** @var Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();

        /** @var HttpRequest $request */
        $request = $this->getRequest();
        $data = $request->getPostValue();
        if ($data) {
            $id = $this->getRequest()->getParam(OrderInterface::ENTITY_ID);
            if (empty($data[OrderInterface::ENTITY_ID])) {
                $data[OrderInterface::ENTITY_ID] = null;
            }

            if ($id) {
                try {
                    /** @var OrderInterface $model */
                    $model = $this->orderRepository->getById($id);
                } catch (NoSuchEntityException $e) {
                    $this->messageManager->addErrorMessage(__($e->getMessage()));
                    /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
                    $resultRedirect = $this->resultRedirectFactory->create();
                    return $resultRedirect->setPath('*/*/');
                }
            } else {
                /** @var OrderModel $model */
                $model = $this->orderFactory->create();
            }
//            $this->processImage($data);
            $model->setData($data);

            try {
                /**
                 * This chunk of code was added in order to check if car customer exists
                 * in database by provided user_id from the form on admin edit page
                 */
                $customerId = (int)$data[OrderInterface::USER_ID];
                $this->customerRepository->getById($customerId);

                $this->orderRepository->save($model);
                $this->messageManager->addSuccessMessage(__('You saved the order.'));
                $this->dataPersistor->clear('order');
                if ($this->getRequest()->getParam('back')) {
                    return $resultRedirect->setPath('*/*/edit', [OrderInterface::ENTITY_ID => $model->getId()]);
                }

                return $resultRedirect->setPath('*/*/');
            } catch (CouldNotSaveException $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
            } catch (LocalizedException $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
            } catch (\Exception $e) {
                $this->messageManager->addExceptionMessage($e, __('Something went wrong while saving the order.'));
            }

            $this->dataPersistor->set('order', $data);
            return $resultRedirect->setPath('*/*/edit', [OrderInterface::ENTITY_ID => $id]);
        }

        return $resultRedirect->setPath('*/*/');
    }

//    /**
//     * @return array
//     */
//    private function processImage(&$data)
//    {
//        $this->filePreprocessing($data, 'logo');
//        $this->filterFileData($data, 'logo');
//        $this->moveImage($data, 'logo');
//    }
//
//    /**
//     * @param array $data
//     * @param string $fieldName
//     */
//    private function filterFileData(&$data, $fieldName)
//    {
//        if (isset($data[$fieldName]) && is_array($data[$fieldName])) {
//            if (!empty($data[$fieldName]['delete'])) {
//                $data[$fieldName] = null;
//            } else {
//                if (isset($data[$fieldName][0]['name']) && isset($data[$fieldName][0]['tmp_name'])) {
//                    $data[$fieldName] = $data[$fieldName][0]['name'];
//                } else {
//                    unset($data[$fieldName]);
//                }
//            }
//        }
//    }

//    /**
//     * @param array $data
//     * @param string $fieldName
//     */
//    private function filePreprocessing(&$data, $fieldName)
//    {
//        if (empty($data[$fieldName])) {
//            unset($data[$fieldName]);
//            $data[$fieldName]['delete'] = true;
//        }
//    }
//
//    /**
//     * @param array $data
//     * @param string $fieldName
//     */
//    private function moveImage(&$data, $fieldName)
//    {
//        if ($data[$fieldName]) {
//            $this->imageUploader->moveFileFromTmp($data[$fieldName]);
//        }
//    }
}