<?php

namespace Slayer\Mobile\Controller\Adminhtml\Manufacturers;

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
use Slayer\Mobile\Api\PhoneRepositoryInterface;
use Slayer\Mobile\Api\Data\PhoneInterface;
use Slayer\Mobile\Api\Data\ManufacturerInterface;
use Slayer\Mobile\Api\Data\ManufacturerInterfaceFactory;
use Slayer\Mobile\Api\ManufacturerRepositoryInterface;
use Slayer\Mobile\Model\ManufacturerModel;

/**
 * Class Save
 */
class Save extends BackendAction implements HttpPostActionInterface
{
    /**
     * {@inheritdoc}
     */
    const ADMIN_RESOURCE = 'Slayer_Mobile::manufacturer_save';

    /**
     * @var DataPersistorInterface
     */
    private $dataPersistor;

    /**
     * @var ManufacturerRepositoryInterface
     */
    private $manufacturerRepository;

    /**
     * @var PhoneRepositoryInterface
     */
    private $phoneRepository;

    /**
     * @var ManufacturerInterfaceFactory
     */
    private $manufacturerFactory;
//
//    /**
//     * @var ImageUploader
//     */
//    private $imageUploader;

    /**
     * @param Context $context
     * @param ManufacturerRepositoryInterface $manufacturerRepository
     * @param PhoneRepositoryInterface $phoneRepository
     * @param ManufacturerInterfaceFactory $manufacturerFactory
     * @param DataPersistorInterface $dataPersistor
    //     * @param ImageUploader $imageUploader
     */
    public function __construct(
        Context $context,
        ManufacturerRepositoryInterface $manufacturerRepository,
        PhoneRepositoryInterface $phoneRepository,
        ManufacturerInterfaceFactory $manufacturerFactory,
        DataPersistorInterface $dataPersistor
//        ImageUploader $imageUploader
    ) {
        $this->dataPersistor = $dataPersistor;
        $this->manufacturerRepository = $manufacturerRepository;
        $this->phoneRepository = $phoneRepository;
        $this->manufacturerFactory = $manufacturerFactory;
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
            $id = $this->getRequest()->getParam(ManufacturerInterface::ENTITY_ID);
            if (empty($data[ManufacturerInterface::ENTITY_ID])) {
                $data[ManufacturerInterface::ENTITY_ID] = null;
            }

            if ($id) {
                try {
                    /** @var ManufacturerInterface $model */
                    $model = $this->manufacturerRepository->getById($id);
                } catch (NoSuchEntityException $e) {
                    $this->messageManager->addErrorMessage(__($e->getMessage()));
                    /** @var Redirect $resultRedirect */
                    $resultRedirect = $this->resultRedirectFactory->create();
                    return $resultRedirect->setPath('*/*/');
                }
            } else {
                /** @var ManufacturerModel $model */
                $model = $this->manufacturerFactory->create();
            }
//            $this->processImage($data);
            $model->setData($data);

            try {
                $this->manufacturerRepository->save($model);
                $this->messageManager->addSuccessMessage(__('You saved the manufacturer.'));
                $this->dataPersistor->clear('manufacturer');
                if ($this->getRequest()->getParam('back')) {
                    return $resultRedirect->setPath('*/*/edit', [ManufacturerInterface::ENTITY_ID => $model->getId()]);
                }

                return $resultRedirect->setPath('*/*/');
            } catch (CouldNotSaveException $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
            } catch (LocalizedException $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
            } catch (\Exception $e) {
                $this->messageManager->addExceptionMessage($e, __('Something went wrong while saving the manufacturer.'));
            }

            $this->dataPersistor->set('manufacturer', $data);
            return $resultRedirect->setPath('*/*/edit', [ManufacturerInterface::ENTITY_ID => $id]);
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