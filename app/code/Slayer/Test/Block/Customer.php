<?php

namespace Slayer\Test\Block;

use Magento\Framework\Api\SearchCriteria;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\Api\SearchResults;
use Magento\Framework\Api\SortOrder;
use Magento\Framework\Api\SortOrderBuilder;
use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;
use Slayer\Test\Api\Data\CustomerInterface;
use Slayer\Test\Api\CustomerRepositoryInterface;
use Slayer\Test\Model\CustomerModel;
use Slayer\Test\Model\ResourceModel\Customer\Collection as CustomerCollection;
use Slayer\Test\Model\ResourceModel\Customer\CollectionFactory as CustomerCollectionFactory;

/**
 * Class Customer
 */
class Customer extends Template
{
    /**
     * @var CustomerCollectionFactory
     */
    private $customerCollectionFactory;

    /**
     * @var CustomerCollection|null
     */
    private $customerCollection;

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
     * @param CustomerCollectionFactory $customerCollectionFactory
     * @param SearchCriteriaBuilder $searchCriteriaBuilder
     * @param CustomerRepositoryInterface $customerRepository
     * @param SortOrderBuilder $sortOrderBuilder
     * @param array $data
     */
    public function __construct(
        Context $context,
        CustomerCollectionFactory $customerCollectionFactory,
        SearchCriteriaBuilder $searchCriteriaBuilder,
        CustomerRepositoryInterface $customerRepository,
        SortOrderBuilder $sortOrderBuilder,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->customerCollectionFactory = $customerCollectionFactory;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
        $this->customerRepository = $customerRepository;
        $this->sortOrderBuilder = $sortOrderBuilder;
    }

    /**
     * @return Template
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    protected function _prepareLayout()
    {
       /* if ($this->customerCollection === null) {
            $this->customerCollection = $this->customerCollectionFactory->create();
            $this->customerCollection->setOrder(CustomerModel::NAME, 'ASC');
        }*/

        if ($this->customerCollection === null) {
            /** @var SortOrder $sortOrder */
            $sortOrder = $this->sortOrderBuilder
                ->setField(CustomerInterface::NAME)
                ->setDirection(SortOrder::SORT_ASC)
                ->create();
            /** @var SearchCriteria|SearchCriteriaInterface $searchCriteria */
            $searchCriteria = $this->searchCriteriaBuilder
                ->addSortOrder($sortOrder)
                ->create();
            /** @var SearchResults $searchResults */
            $searchResults = $this->customerRepository->getList($searchCriteria);
            if ($searchResults->getTotalCount() > 0) {
                $this->customerCollection = $searchResults->getItems();
            }
        }

        return parent::_prepareLayout();
    }

    /**
     * @return CustomerCollection|null
     */
    public function getCustomerCollection()
    {
        return $this->customerCollection;
    }
}
