<?php

namespace Slayer\Test\Block;

use Magento\Framework\Api\SearchCriteria;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\Api\SearchResultsInterface;
use Magento\Framework\Api\SortOrder;
use Magento\Framework\Api\SortOrderBuilder;
use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;
use Slayer\Test\Api\Data\CustomerInterface;
use Slayer\Test\Api\CustomerRepositoryInterface;
//use Slayer\Test\Model\ResourceModel\Customer\Collection as CustomerCollection;
//use Slayer\Test\Model\ResourceModel\Customer\CollectionFactory as CustomerCollectionFactory;
use Slayer\Test\Api\Data\OrderInterface;

/**
 * Class Customer
 */
class Customer extends Template
{

    const ORDERS_ACTION_ROUTE = 'test/customer/orders';

    /**
//     * @var CustomerCollectionFactory
     */
//    private $customerCollectionFactory;

    /**
//     * @var CustomerCollection|null
     */
//    private $customerCollection;

    /**
     * @var CustomerInterface[]|null
     */
    private $customers;

    /**
     * @var SearchCriteriaBuilder
     */
    private $searchCriteriaBuilder;

    /**
     * @var CustomerRepositoryInterface
     */
    private $customerRepository;

    /**
     * @var SortOrderBuilder
     */
    private $sortOrderBuilder;

    /**
     * @param Context $context
//     * @param CustomerCollectionFactory $customerCollectionFactory
     * @param SearchCriteriaBuilder $searchCriteriaBuilder
     * @param CustomerRepositoryInterface $customerRepository
     * @param SortOrderBuilder $sortOrderBuilder
     * @param array $data
     */
    public function __construct(
        Context $context,
//        CustomerCollectionFactory $customerCollectionFactory,
        SearchCriteriaBuilder $searchCriteriaBuilder,
        CustomerRepositoryInterface $customerRepository,
        SortOrderBuilder $sortOrderBuilder,
        array $data = []
    ) {
        parent::__construct($context, $data);
//        $this->customerCollectionFactory = $customerCollectionFactory;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
        $this->customerRepository = $customerRepository;
        $this->sortOrderBuilder = $sortOrderBuilder;
    }

    /**
     * {@inheritDoc}
     */
    protected function _prepareLayout()
    {
        if ($this->customers === null) {
            $this->customers = [];
            try {
                /** @var SortOrder $sortOrder */
                $sortOrder = $this->sortOrderBuilder
                    ->setField(CustomerInterface::NAME)
                    ->setDirection(SortOrder::SORT_ASC)
                    ->create();
                /** @var SearchCriteria|SearchCriteriaInterface $searchCriteria */
                $searchCriteria = $this->searchCriteriaBuilder
                    ->addSortOrder($sortOrder)
                    ->create();
                /** @var SearchResultsInterface $searchResults */
                $searchResults = $this->customerRepository->getList($searchCriteria);
                if ($searchResults->getTotalCount() > 0) {
                    $this->customers = $searchResults->getItems();
                }
            } catch (\Exception $exception) {
                $error = $exception->getMessage();
                $text = 'Customers loading has failed: message "%s"';
                $message = sprintf($text, $error);
                $this->_logger->debug($message);
            }
        }

        return parent::_prepareLayout();
    }

    /**
     * @return CustomerInterface[]|null
     */
    public function getCustomers()
    {
        return $this->customers;
    }

    /**
     * @param string|int $userId
     * @return string
     */
    public function getOrdersUrl($userId)
    {
        return $this->getUrl(
            self::ORDERS_ACTION_ROUTE,
            [
                OrderInterface::USER_ID => $userId
            ]
        );
    }

//    /**
//     * @return Template
//     * @throws \Magento\Framework\Exception\LocalizedException
//     */
//    protected function _prepareLayout()
//    {
//       /* if ($this->customerCollection === null) {
//            $this->customerCollection = $this->customerCollectionFactory->create();
//            $this->customerCollection->setOrder(CustomerModel::NAME, 'ASC');
//        }*/
//
//        if ($this->customerCollection === null) {
//            /** @var SortOrder $sortOrder */
//            $sortOrder = $this->sortOrderBuilder
//                ->setField(CustomerInterface::NAME)
//                ->setDirection(SortOrder::SORT_ASC)
//                ->create();
//            /** @var SearchCriteria|SearchCriteriaInterface $searchCriteria */
//            $searchCriteria = $this->searchCriteriaBuilder
//                ->addSortOrder($sortOrder)
//                ->create();
//            /** @var SearchResults $searchResults */
//            $searchResults = $this->customerRepository->getList($searchCriteria);
//            if ($searchResults->getTotalCount() > 0) {
//                $this->customerCollection = $searchResults->getItems();
//            }
//        }
//
//        return parent::_prepareLayout();
//    }
//
//    /**
//     * @return CustomerCollection|null
//     */
//    public function getCustomerCollection()
//    {
//        return $this->customerCollection;
//    }
}
