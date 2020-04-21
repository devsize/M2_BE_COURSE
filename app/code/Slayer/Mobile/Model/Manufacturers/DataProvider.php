<?php

namespace Slayer\Mobile\Model\Manufacturers;

use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Framework\UrlInterface;
use Magento\Ui\DataProvider\AbstractDataProvider;
use Slayer\Mobile\Api\Data\ManufacturerInterface;
use Slayer\Mobile\Model\ResourceModel\Manufacturer\Collection as ManufacturersCollection;
use Slayer\Mobile\Model\ResourceModel\Manufacturer\CollectionFactory as ManufacturersCollectionFactory;

/**
 * Class DataProvider
 */
class DataProvider extends AbstractDataProvider
{
    /**
     * @var ManufacturersCollection
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
     * @param ManufacturersCollectionFactory $manufacturersCollectionFactory
     * @param DataPersistorInterface $dataPersistor
     * @param UrlInterface $urlBuilder
     * @param array $meta
     * @param array $data
     */
    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        ManufacturersCollectionFactory $manufacturersCollectionFactory,
        DataPersistorInterface $dataPersistor,
        UrlInterface $urlBuilder,
        array $meta = [],
        array $data = []
    ) {
        $this->collection = $manufacturersCollectionFactory->create();
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
            /** @var ManufacturerInterface $manufacturer */
            foreach ($items as $manufacturer) {
                $this->loadedData[$manufacturer->getId()] = $this->prepareData($manufacturer);
            }

            $data = $this->dataPersistor->get('manufacturers');
            if (!empty($data)) {
                $manufacturer = $this->collection->getNewEmptyItem();
                $manufacturer->setData($data);
                $this->loadedData[$manufacturer->getId()] = $this->prepareData($manufacturer);
                $this->dataPersistor->clear('manufacturers');
            }
        }
        return $this->loadedData;
    }

    /**
     * @param ManufacturerInterface $manufacturer
     * @return array
     */
    private function prepareData($manufacturer)
    {
        $data = $manufacturer->getData();

        if (isset($data['logo'])) {
            unset($data['logo']);
            $data['logo'][0]['name'] = $manufacturer->getData('logo');
            $data['logo'][0]['url'] = $this->getFileUrl($manufacturer->getLogo());
        }

        return $data;
    }

    /**
     * @param string $fileName
     * @return string
     */
    private function getFileUrl($fileName)
    {
        return $this->urlBuilder->getBaseUrl(['_type' => UrlInterface::URL_TYPE_MEDIA]) . 'manufacturers/' . $fileName;
    }
}