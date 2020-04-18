<?php

namespace Slayer\Mobile\Controller\Adminhtml\Phones;

use Magento\Backend\App\Action as BackendAction;
use Magento\Backend\App\Action\Context;
use Magento\Backend\Model\View\Result\Redirect;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Ui\Component\MassAction\Filter;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;
use Slayer\Mobile\Api\Data\PhoneInterface;
use Slayer\Mobile\Api\PhoneRepositoryInterface;
use Slayer\Mobile\Model\ResourceModel\Phone\Collection as PhoneCollection;
use Slayer\Mobile\Model\ResourceModel\Phone\CollectionFactory as PhoneResourceCollectionFactory;

/**
 * Class MassDelete
 */
class MassDelete extends BackendAction implements HttpPostActionInterface
{
    /**
     * {@inheritdoc}
     */
    const ADMIN_RESOURCE = 'Slayer_Mobile::phone_mass_delete';

    /**
     * @var DataPersistorInterface
     */
    private $dataPersistor;

    /**
     * @var PhoneRepositoryInterface
     */
    private $phoneRepository;

    /**
     * @var Filter
     */
    private $filter;

    /**
     * @var PhoneResourceCollectionFactory
     */
    private $collectionFactory;

    /**
     * @param Context $context
     * @param PhoneRepositoryInterface $phoneRepository
     * @param PhoneResourceCollectionFactory $collectionFactory
     * @param Filter $filter
     * @param DataPersistorInterface $dataPersistor
     */
    public function __construct(
        Context $context,
        PhoneRepositoryInterface $phoneRepository,
        PhoneResourceCollectionFactory $collectionFactory,
        Filter $filter,
        DataPersistorInterface $dataPersistor
    ) {
        $this->dataPersistor = $dataPersistor;
        $this->filter = $filter;
        $this->phoneRepository = $phoneRepository;
        $this->collectionFactory = $collectionFactory;
        parent::__construct($context);
    }

    /**
     * @return ResultInterface
     */
    public function execute()
    {
        /** @var Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();

        try {
            /** @var PhoneCollection $collection */
            $collection = $this->filter->getCollection($this->collectionFactory->create());
            $count = 0;
            foreach ($collection as $phone) {
                /** @var PhoneInterface $phone */
                if ($this->phoneRepository->delete($phone)) {
                    $count++;
                }
            }

            $message = __('A total of %1 record(s) have been deleted.', $count);
            $this->messageManager->addSuccessMessage($message);
            $this->dataPersistor->clear('phone');
            return $resultRedirect->setPath('*/*/');
        } catch (NoSuchEntityException $e) {
            $this->messageManager->addErrorMessage($e->getMessage());
        } catch (LocalizedException $e) {
            $this->messageManager->addErrorMessage($e->getMessage());
        } catch (\Exception $e) {
            $this->messageManager->addExceptionMessage($e, __('Something went wrong while deleting phones.'));
        }

        return $resultRedirect->setPath('*/*/');
    }
}