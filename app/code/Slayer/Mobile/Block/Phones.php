<?php

namespace Slayer\Mobile\Block;

use Magento\Framework\Api\SearchCriteria;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\Api\SearchResultsInterface;
use Magento\Framework\App\Request\Http;
use Slayer\Mobile\Model\ManufacturerModel;
use Slayer\Mobile\Model\PhoneModel;
use Magento\Framework\Api\SortOrder;
use Magento\Framework\Api\SortOrderBuilder;
use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;
use Slayer\Mobile\Api\Data\PhoneInterface;
//use Slayer\Mobile\Api\PhoneRepositoryInterface;
use Slayer\Mobile\Model\ResourceModel\Phone\Collection as PhonesCollection;
use Slayer\Mobile\Model\ResourceModel\Phone\CollectionFactory as PhonesCollectionFactory;

/**
 * Class Phones
 */
class Phones extends Template
{

//    const PHONES_ACTION_ROUTE = 'mobile/phone/phones';

    /**
     * @var PhonesCollectionFactory
     */
    private $phonesCollectionFactory;

    /**
     * @var PhonesCollection|null
     */
    private $phonesCollection;

    /**
     * @var PhoneInterface[]|null
     */
    private $phones;

    /**
//     * @var SearchCriteriaBuilder
     */
//    private $searchCriteriaBuilder;

    /**
//     * @var PhoneRepositoryInterface
     */
//    private $phoneRepository;

    /**
//     * @var SortOrderBuilder
     */
//    private $sortOrderBuilder;

    /**
     * @param Context $context
     * @param PhonesCollectionFactory $phonesCollectionFactory
//     * @param SearchCriteriaBuilder $searchCriteriaBuilder
//     * @param PhoneRepositoryInterface $phoneRepository
//     * @param SortOrderBuilder $sortOrderBuilder
     * @param array $data
     */
    public function __construct(
        Context $context,
        PhonesCollectionFactory $phonesCollectionFactory,
//        SearchCriteriaBuilder $searchCriteriaBuilder,
//        PhoneRepositoryInterface $phoneRepository,
//        SortOrderBuilder $sortOrderBuilder,
        array $data = []
    ) {
        parent::__construct($context, $data);
//        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
        $this->phonesCollectionFactory = $phonesCollectionFactory;
//        $this->phoneRepository = $phoneRepository;
//        $this->sortOrderBuilder = $sortOrderBuilder;
    }

    /**
     * @return Template
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    protected function _prepareLayout()
    {
        /** @var \Magento\Framework\App\Request\Http $request */
        $request = $this->getRequest();
        $manufacturerId = (int)$request->getParam(PhoneInterface::MANUFACTURER_ID);
        if ($manufacturerId > 0 && $this->phonesCollection === null) {
            $this->phonesCollection = $this->phonesCollectionFactory->create();
            $this->phonesCollection->addFieldToFilter(
                PhoneInterface::MANUFACTURER_ID,
                ['eq' => $manufacturerId]
            );
        }
//        /** @var Http $request */
//        $request = $this->getRequest();
//        $phoneId = (int)$request->getParam(PhoneInterface::MANUFACTURER_ID);
//        if ($phoneId > 0 && $this->phones === null) {
//            $this->phones = [];
//            try {
//                /** @var SortOrder $sortOrder */
//                $sortOrder = $this->sortOrderBuilder
//                    ->setField(OrderInterface::CREATED_AT)
//                    ->setDirection(SortOrder::SORT_ASC)
//                    ->create();
//                /** @var SearchCriteria|SearchCriteriaInterface $searchCriteria */
//                $searchCriteria = $this->searchCriteriaBuilder
//                    ->addFilter(OrderInterface::USER_ID, $userId)
//                    ->addSortOrder($sortOrder)
//                    ->create();
//                /** @var SearchResultsInterface $searchResults */
//                $searchResults = $this->orderRepository->getList($searchCriteria);
//                if ($searchResults->getTotalCount() > 0) {
//                    $this->orders = $searchResults->getItems();
//                }
//            } catch (\Exception $exception) {
//                $error = $exception->getMessage();
//                $text = 'Orders loading has failed: message "%s"';
//                $message = sprintf($text, $error);
//                $this->_logger->debug($message);
//            }
//        }

        return parent::_prepareLayout();
    }

    /**
     * @return PhonesCollection|null
     */
    public function getPhonesCollection()
    {
        return $this->phonesCollection;
    }
}
