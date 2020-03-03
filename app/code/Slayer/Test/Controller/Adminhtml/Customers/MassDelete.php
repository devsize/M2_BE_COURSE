<?php

namespace Slayer\Test\Controller\Adminhtml\Cars;

use Magento\Backend\App\Action as BackendAction;
use Magento\Backend\App\Action\Context;
use Magento\Backend\Model\View\Result\Redirect;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Ui\Component\MassAction\Filter;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;
use Slayer\Test\Api\Data\OrderInterface;
use Slayer\Test\Api\OrderRepositoryInterface;
use Slayer\Test\Model\ResourceModel\Order\Collection as OrderCollection;
use Slayer\Test\Model\ResourceModel\Order\CollectionFactory as OrderResourceCollectionFactory;

/**
 * Class MassDelete
 */
class MassDelete extends BackendAction implements HttpPostActionInterface
{
    /**
     * {@inheritdoc}
     */
    const ADMIN_RESOURCE = 'Slayer_Test::order_mass_delete';

    /**
     * @var DataPersistorInterface
     */
    private $dataPersistor;

    /**
     * @var OrderRepositoryInterface
     */
    private $orderRepository;

    /**
     * @var Filter
     */
    private $filter;

    /**
     * @var OrderResourceCollectionFactory
     */
    private $collectionFactory;

    /**
     * @param Context $context
     * @param OrderRepositoryInterface $orderRepository
     * @param OrderResourceCollectionFactory $collectionFactory
     * @param Filter $filter
     * @param DataPersistorInterface $dataPersistor
     */
    public function __construct(
        Context $context,
        OrderRepositoryInterface $orderRepository,
        OrderResourceCollectionFactory $collectionFactory,
        Filter $filter,
        DataPersistorInterface $dataPersistor
    ) {
        $this->dataPersistor = $dataPersistor;
        $this->filter = $filter;
        $this->orderRepository = $orderRepository;
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
            /** @var OrderCollection $collection */
            $collection = $this->filter->getCollection($this->collectionFactory->create());
            $count = 0;
            foreach ($collection as $car) {
                /** @var OrderInterface $car */
                if ($this->orderRepository->delete($car)) {
                    $count++;
                }
            }

            $message = __('A total of %1 record(s) have been deleted.', $count);
            $this->messageManager->addSuccessMessage($message);
            $this->dataPersistor->clear('order');
            return $resultRedirect->setPath('*/*/');
        } catch (NoSuchEntityException $e) {
            $this->messageManager->addErrorMessage($e->getMessage());
        } catch (LocalizedException $e) {
            $this->messageManager->addErrorMessage($e->getMessage());
        } catch (\Exception $e) {
            $this->messageManager->addExceptionMessage($e, __('Something went wrong while deleting orders.'));
        }

        return $resultRedirect->setPath('*/*/');
    }
}