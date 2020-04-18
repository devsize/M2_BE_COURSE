<?php

namespace Slayer\Mobile\Controller\Adminhtml\Manufacturers;

use Magento\Backend\App\Action as BackendAction;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\Controller\Result\Json;
use Magento\Framework\Controller\Result\JsonFactory;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Exception\CouldNotSaveException;
use Slayer\Mobile\Api\Data\ManufacturerInterface;
use Slayer\Mobile\Api\ManufacturerRepositoryInterface;
use Slayer\Mobile\Model\ManufacturerModel;

/**
 * Class InlineEdit
 */
class InlineEdit extends BackendAction implements HttpPostActionInterface
{
    /**
     * {@inheritdoc}
     */
    const ADMIN_RESOURCE = 'Slayer_Mobile::manufacturer_inline_edit';

    /**
     * @var JsonFactory
     */
    private $jsonFactory;

    /**
     * @var ManufacturerRepositoryInterface
     */
    private $manufacturerRepository;

    /**
     * @param Context $context
     * @param ManufacturerRepositoryInterface $manufacturerRepository
     * @param JsonFactory $jsonFactory
     */
    public function __construct(
        Context $context,
        ManufacturerRepositoryInterface $manufacturerRepository,
        JsonFactory $jsonFactory
    ) {
        $this->manufacturerRepository = $manufacturerRepository;
        $this->jsonFactory = $jsonFactory;
        parent::__construct($context);
    }

    /**
     * @return ResultInterface
     */
    public function execute()
    {
        /** @var Json $resultJson */
        $resultJson = $this->jsonFactory->create();
        $error = false;
        $messages = [];

        if ($this->getRequest()->getParam('isAjax')) {
            $postItems = $this->getRequest()->getParam('items', []);
            if (empty($postItems)) {
                $messages[] = __('Please correct the data sent.');
                $error = true;
            } else {
                foreach (array_keys($postItems) as $id) {
                    try {
                        /** @var ManufacturerInterface $model */
                        $model = $this->manufacturerRepository->getById($id);
                        $model->setData(array_merge($model->getData(), $postItems[$id]));
                        $this->manufacturerRepository->save($model);
                    } catch (NoSuchEntityException $e) {
                        $messages[] = $e->getMessage();
                        $error = true;
                    } catch (CouldNotSaveException $e) {
                        $messages[] = $e->getMessage();
                        $error = true;
                    } catch (\Exception $e) {
                        $messages[] = $e->getMessage();
                        $error = true;
                    }
                }
            }
        }

        return $resultJson->setData([
            'messages' => $messages,
            'error' => $error
        ]);
    }
}