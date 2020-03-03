<?php

namespace Slayer\Test\Model\Customers;

use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Framework\UrlInterface;
use Magento\Ui\DataProvider\AbstractDataProvider;
use Slayer\Test\Api\Data\CustomerInterface;
use Slayer\Test\Model\ResourceModel\Customer\Collection as CustomersCollection;
use Slayer\Test\Model\ResourceModel\Customer\CollectionFactory as CustomersCollectionFactory;

/**
 * Class DataProvider
 */
class DataProvider extends AbstractDataProvider
{
    /**
     * @var CustomersCollection
     */
    protected $collection;

    /**
     * @var DataPersistorInterface
     */
    protected $dataPersistor;

    /**
     * @var array|null
     */
    protected $loadedData;

    /**
     * Url Builder
     *
     * @var UrlInterface
     */
    private $urlBuilder;

    /**
     * @param string $name
     * @param string $primaryFieldName
     * @param string $requestFieldName
     * @param CustomersCollectionFactory $customersCollectionFactory
     * @param DataPersistorInterface $dataPersistor
     * @param UrlInterface $urlBuilder
     * @param array $meta
     * @param array $data
     */
    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        CustomersCollectionFactory $customersCollectionFactory,
        DataPersistorInterface $dataPersistor,
        UrlInterface $urlBuilder,
        array $meta = [],
        array $data = []
    ) {
        $this->collection = $customersCollectionFactory->create();
        $this->dataPersistor = $dataPersistor;
        $this->urlBuilder = $urlBuilder;
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
    }

    /**
     * {@inheritDoc}
     */
    public function getData()
    {
        if ($this->loadedData === null) {
            $this->loadedData = [];
            $items = $this->collection->getItems();
            /** @var CustomerInterface $customer */
            foreach ($items as $customer) {
                $this->loadedData[$customer->getId()] = $this->prepareData($customer);
            }

            $data = $this->dataPersistor->get('customers');
            if (!empty($data)) {
                $customer = $this->collection->getNewEmptyItem();
                $customer->setData($data);
                $this->loadedData[$customer->getId()] = $this->prepareData($customer);
                $this->dataPersistor->clear('customers');
            }
        }

        return $this->loadedData;
    }

    /**
     * @param CustomerInterface $customer
     * @return array
     */
    private function prepareData($customer)
    {
        $data = $customer->getData();
        return $data;

        if (isset($data['logo'])) {
            unset($data['logo']);
            $data['logo'][0]['name'] = $customer->getData('logo');
            $data['logo'][0]['url'] = $this->getFileUrl($customer->getLogo());
        }

        return $data;
    }

    /**
     * @param string $fileName
     * @return string
     */
    private function getFileUrl($fileName)
    {
        return $this->urlBuilder->getBaseUrl(['_type' => UrlInterface::URL_TYPE_MEDIA]) . 'customers/' . $fileName;
    }
}