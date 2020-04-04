<?php

namespace Slayer\Mobile\Block;

use Magento\Framework\Api\SearchCriteria;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\Api\SearchResultsInterface;
use Magento\Framework\Api\SortOrder;
use Magento\Framework\Api\SortOrderBuilder;
use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;
use Slayer\Mobile\Api\Data\ManufacturerInterface;
use Slayer\Mobile\Api\ManufacturerRepositoryInterface;
//use Slayer\Mobile\Model\ResourceModel\Manufacturer\Collection as ManufacturerCollection;
//use Slayer\Mobile\Model\ResourceModel\Manufacturer\CollectionFactory as ManufacturerCollectionFactory;
use Slayer\Mobile\Api\Data\PhoneInterface;

/**
 * Class Manufacturer
 */
class Manufacturer extends Template
{

    const PHONES_ACTION_ROUTE = 'mobile/manufacturer/phones';

    /**
     * @var ManufacturerInterface[]|null
     */
    private $manufacturers;

    /**
     * @var SearchCriteriaBuilder
     */
    private $searchCriteriaBuilder;

    /**
     * @var ManufacturerRepositoryInterface
     */
    private $manufacturerRepository;

    /**
     * @var SortOrderBuilder
     */
    private $sortOrderBuilder;

    /**
     * @param Context $context
     * @param SearchCriteriaBuilder $searchCriteriaBuilder
     * @param ManufacturerRepositoryInterface $manufacturerRepository
     * @param SortOrderBuilder $sortOrderBuilder
     * @param array $data
     */
    public function __construct(
        Context $context,
        SearchCriteriaBuilder $searchCriteriaBuilder,
        ManufacturerRepositoryInterface $manufacturerRepository,
        SortOrderBuilder $sortOrderBuilder,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
        $this->manufacturerRepository = $manufacturerRepository;
        $this->sortOrderBuilder = $sortOrderBuilder;
    }

    /**
     * {@inheritDoc}
     */
    protected function _prepareLayout()
    {
        if ($this->manufacturers === null) {
            $this->manufacturers = [];
            try {
                /** @var SortOrder $sortOrder */
                $sortOrder = $this->sortOrderBuilder
                    ->setField(ManufacturerInterface::NAME)
                    ->setDirection(SortOrder::SORT_ASC)
                    ->create();
                /** @var SearchCriteria|SearchCriteriaInterface $searchCriteria */
                $searchCriteria = $this->searchCriteriaBuilder
                    ->addSortOrder($sortOrder)
                    ->create();
                /** @var SearchResultsInterface $searchResults */
                $searchResults = $this->manufacturerRepository->getList($searchCriteria);
                if ($searchResults->getTotalCount() > 0) {
                    $this->manufacturers = $searchResults->getItems();
                }
            } catch (\Exception $exception) {
                $error = $exception->getMessage();
                $text = 'Manufacturers loading has failed: message "%s"';
                $message = sprintf($text, $error);
                $this->_logger->debug($message);
            }
        }

        return parent::_prepareLayout();
    }

    /**
     * @return ManufacturerInterface[]|null
     */
    public function getManufacturers()
    {
        return $this->manufacturers;
    }

    /**
     * @param string|int $id
     * @return string
     */
    public function getPhonesUrl($id)
    {
        return $this->getUrl(
            self::PHONES_ACTION_ROUTE,
            [
                PhoneInterface::ID => $id
            ]
        );
    }
}
