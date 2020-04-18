<?php

namespace Slayer\Mobile\Controller\Adminhtml\Phones;

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
use Slayer\Mobile\Api\ManufacturerRepositoryInterface;
use Slayer\Mobile\Api\Data\ManufacturerInterface;
use Slayer\Mobile\Api\Data\PhoneInterface;
use Slayer\Mobile\Api\Data\PhoneInterfaceFactory;
use Slayer\Mobile\Api\PhoneRepositoryInterface;
use Slayer\Mobile\Model\PhoneModel;

/**
 * Class Save
 */
class Save extends BackendAction implements HttpPostActionInterface
{
    /**
     * {@inheritdoc}
     */
    const ADMIN_RESOURCE = 'Slayer_Mobile::phone_save';

    /**
     * @var DataPersistorInterface
     */
    private $dataPersistor;

    /**
     * @var PhoneRepositoryInterface
     */
    private $phoneRepository;

    /**
     * @var ManufacturerRepositoryInterface
     */
    private $manufacturerRepository;

    /**
     * @var PhoneInterfaceFactory
     */
    private $phoneFactory;
//
//    /**
//     * @var ImageUploader
//     */
//    private $imageUploader;

    /**
     * @param Context $context
     * @param PhoneRepositoryInterface $phoneRepository
     * @param ManufacturerRepositoryInterface $manufacturerRepository
     * @param PhoneInterfaceFactory $phoneFactory
     * @param DataPersistorInterface $dataPersistor
    //     * @param ImageUploader $imageUploader
     */
    public function __construct(
        Context $context,
        PhoneRepositoryInterface $phoneRepository,
        ManufacturerRepositoryInterface $manufacturerRepository,
        PhoneInterfaceFactory $phoneFactory,
        DataPersistorInterface $dataPersistor
//        ImageUploader $imageUploader
    ) {
        $this->dataPersistor = $dataPersistor;
        $this->phoneRepository = $phoneRepository;
        $this->manufacturerRepository = $manufacturerRepository;
        $this->phoneFactory = $phoneFactory;
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
            $id = $this->getRequest()->getParam(PhoneInterface::ENTITY_ID);
            if (empty($data[PhoneInterface::ENTITY_ID])) {
                $data[PhoneInterface::ENTITY_ID] = null;
            }

            if ($id) {
                try {
                    /** @var PhoneInterface $model */
                    $model = $this->phoneRepository->getById($id);
                } catch (NoSuchEntityException $e) {
                    $this->messageManager->addErrorMessage(__($e->getMessage()));
                    /** @var Redirect $resultRedirect */
                    $resultRedirect = $this->resultRedirectFactory->create();
                    return $resultRedirect->setPath('*/*/');
                }
            } else {
                /** @var PhoneModel $model */
                $model = $this->phoneFactory->create();
            }
//            $this->processImage($data);
            $model->setData($data);

            try {
                /**
                 * This chunk of code was added in phone to check if phone exists
                 * in database by provided manufacturer_id from the form on admin edit page
                 */
                $manufacturerId = (int)$data[PhoneInterface::MANUFACTURER_ID];
                $this->manufacturerRepository->getById($manufacturerId);

                $this->phoneRepository->save($model);
                $this->messageManager->addSuccessMessage(__('You saved the phone.'));
                $this->dataPersistor->clear('phone');
                if ($this->getRequest()->getParam('back')) {
                    return $resultRedirect->setPath('*/*/edit', [PhoneInterface::ENTITY_ID => $model->getId()]);
                }

                return $resultRedirect->setPath('*/*/');
            } catch (CouldNotSaveException $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
            } catch (LocalizedException $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
            } catch (\Exception $e) {
                $this->messageManager->addExceptionMessage($e, __('Something went wrong while saving the phone.'));
            }

            $this->dataPersistor->set('phone', $data);
            return $resultRedirect->setPath('*/*/edit', [PhoneInterface::ENTITY_ID => $id]);
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