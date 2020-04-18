<?php

namespace Slayer\Mobile\Controller\Adminhtml\Phones;

use Magento\Backend\App\Action as BackendAction;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\View\Result\PageFactory;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Exception\NoSuchEntityException;
use Slayer\Mobile\Api\Data\PhoneInterface;
use Slayer\Mobile\Api\Data\PhoneInterfaceFactory;
use Slayer\Mobile\Api\PhoneRepositoryInterface;
use Magento\Backend\Model\View\Result\Redirect;

/**
 * Class Edit
 */
class Edit extends BackendAction implements HttpGetActionInterface
{
    /**
     * {@inheritdoc}
     */
    const ADMIN_RESOURCE = 'Slayer_Mobile::phone_edit';

    /**
     * @var PageFactory
     */
    private $resultPageFactory;

    /**
     * @var PhoneRepositoryInterface
     */
    private $phoneRepository;

    /**
     * @var PhoneInterfaceFactory
     */
    private $phoneFactory;

    /**
     * @param Context $context
     * @param PhoneRepositoryInterface $phoneRepository
     * @param PhoneInterfaceFactory $phoneFactory
     * @param PageFactory $resultPageFactory
     */
    public function __construct(
        Context $context,
        PhoneRepositoryInterface $phoneRepository,
        PhoneInterfaceFactory $phoneFactory,
        PageFactory $resultPageFactory
    ) {
        $this->phoneRepository = $phoneRepository;
        $this->phoneFactory = $phoneFactory;
        $this->resultPageFactory = $resultPageFactory;
        parent::__construct($context);
    }

    /**
     * @return ResultInterface
     */
    public function execute()
    {
        $id = (int)$this->getRequest()->getParam(PhoneInterface::ENTITY_ID);

        if ($id) {
            try {
                $model = $this->phoneRepository->getById($id);
            } catch (NoSuchEntityException $e) {
                $this->messageManager->addErrorMessage(__($e->getMessage()));
                /** @var Redirect $resultRedirect */
                $resultRedirect = $this->resultRedirectFactory->create();
                return $resultRedirect->setPath('*/*/');
            }
        } else {
            $model = $this->phoneFactory->create();
        }

        /** @var ResultInterface $resultPage */
        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu('Slayer_Mobile::manage_phones');

        $resultPage->getConfig()->getTitle()->prepend(__('Phone'));
        $resultPage->getConfig()->getTitle()->prepend($model->getId() ? $model->getName() : __('New Phone'));
        return $resultPage;
    }
}