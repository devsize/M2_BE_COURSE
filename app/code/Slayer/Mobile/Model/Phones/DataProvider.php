<?php

namespace Slayer\Mobile\Model\Phones;

use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Framework\UrlInterface;
use Magento\Ui\DataProvider\AbstractDataProvider;
use Slayer\Mobile\Api\Data\PhoneInterface;
use Slayer\Mobile\Model\ResourceModel\Phone\Collection as PhonesCollection;
use Slayer\Mobile\Model\ResourceModel\Phone\CollectionFactory as PhonesCollectionFactory;
use Magento\Store\Model\StoreManagerInterface;

/**
 * Class DataProvider
 */
class DataProvider extends AbstractDataProvider
{
    /**
     * @var PhonesCollection
     */
    protected $collection;

    /**
     * @var DataPersistorInterface
     */
    protected $dataPersistor;

    /**
     * @var array
     */
    public $_storeManager;

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
     * @param StoreManagerInterface $storeManager
     * @param PhonesCollectionFactory $phonesCollectionFactory
     * @param DataPersistorInterface $dataPersistor
     * @param UrlInterface $urlBuilder
     * @param array $meta
     * @param array $data
     */
    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        PhonesCollectionFactory $phonesCollectionFactory,
        StoreManagerInterface $storeManager,
        DataPersistorInterface $dataPersistor,
        UrlInterface $urlBuilder,
        array $meta = [],
        array $data = []
    ) {
        $this->collection = $phonesCollectionFactory->create();
        $this->dataPersistor = $dataPersistor;
        $this->urlBuilder = $urlBuilder;
        $this->_storeManager=$storeManager;
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
    }

    /**
     * @return array|null
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getData()
    {

        if ($this->loadedData === null) {
            $this->loadedData = [];
            $items = $this->collection->getItems();
            /** @var PhoneInterface $phone */
            foreach ($items as $phone) {
                $this->loadedData[$phone->getId()] = $this->prepareData($phone);
            }

            $data = $this->dataPersistor->get('phones');
            if (!empty($data)) {
                $phone = $this->collection->getNewEmptyItem();
                $phone->setData($data);
                $this->loadedData[$phone->getId()] = $this->prepareData($phone);
                $this->dataPersistor->clear('phones');
            }
        }
        return $this->loadedData;
    }

    /**
     * @param PhoneInterface $phone
     * @return array
     */
    private function prepareData($phone)
    {
        $data = $phone->getData();

        if (isset($data['logo'])) {
            unset($data['logo']);
            $data['logo'][0]['name'] = $phone->getData('logo');
            $data['logo'][0]['url'] = $this->getFileUrl($phone->getLogo());
        }

        return $data;
    }

    /**
     * @param string $fileName
     * @return string
     */
    private function getFileUrl($fileName)
    {
        return $this->urlBuilder->getBaseUrl(['_type' => UrlInterface::URL_TYPE_MEDIA]) . 'phones/' . $fileName;
    }
}