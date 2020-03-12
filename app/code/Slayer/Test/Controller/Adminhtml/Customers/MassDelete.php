<?php

namespace Slayer\Test\Controller\Adminhtml\Customers;

use Magento\Backend\App\Action as BackendAction;
use Magento\Backend\App\Action\Context;
use Magento\Backend\Model\View\Result\Redirect;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Ui\Component\MassAction\Filter;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;
use Slayer\Test\Api\Data\CustomerInterface;
use Slayer\Test\Api\CustomerRepositoryInterface;
use Slayer\Test\Model\ResourceModel\Customer\Collection as CustomerCollection;
use Slayer\Test\Model\ResourceModel\Customer\CollectionFactory as CustomerResourceCollectionFactory;

/**
 * Class MassDelete
 */
class MassDelete extends BackendAction implements HttpPostActionInterface
{
    /**
     * {@inheritdoc}
     */
    const ADMIN_RESOURCE = 'Slayer_Test::customer_mass_delete';

    /**
     * @var DataPersistorInterface
     */
    private $dataPersistor;

    /**
     * @var CustomerRepositoryInterface
     */
    private $customerRepository;

    /**
     * @var Filter
     */
    private $filter;

    /**
     * @var CustomerResourceCollectionFactory
     */
    private $collectionFactory;

    /**
     * @param Context $context
     * @param CustomerRepositoryInterface $customerRepository
     * @param CustomerResourceCollectionFactory $collectionFactory
     * @param Filter $filter
     * @param DataPersistorInterface $dataPersistor
     */
    public function __construct(
        Context $context,
        CustomerRepositoryInterface $customerRepository,
        CustomerResourceCollectionFactory $collectionFactory,
        Filter $filter,
        DataPersistorInterface $dataPersistor
    ) {
        $this->dataPersistor = $dataPersistor;
        $this->filter = $filter;
        $this->customerRepository = $customerRepository;
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
            /** @var CustomerCollection $collection */
            $collection = $this->filter->getCollection($this->collectionFactory->create());
            $count = 0;
            foreach ($collection as $car) {
                /** @var CustomerInterface $car */
                if ($this->customerRepository->delete($car)) {
                    $count++;
                }
            }

            $message = __('A total of %1 record(s) have been deleted.', $count);
            $this->messageManager->addSuccessMessage($message);
            $this->dataPersistor->clear('customer');
            return $resultRedirect->setPath('*/*/');
        } catch (NoSuchEntityException $e) {
            $this->messageManager->addErrorMessage($e->getMessage());
        } catch (LocalizedException $e) {
            $this->messageManager->addErrorMessage($e->getMessage());
        } catch (\Exception $e) {
            $this->messageManager->addExceptionMessage($e, __('Something went wrong while deleting customers.'));
        }

        return $resultRedirect->setPath('*/*/');
    }
}