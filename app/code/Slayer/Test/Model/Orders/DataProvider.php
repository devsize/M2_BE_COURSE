<?php

namespace Slayer\Test\Model\Orders;

use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Framework\UrlInterface;
use Magento\Ui\DataProvider\AbstractDataProvider;
use Slayer\Test\Api\Data\OrderInterface;
use Slayer\Test\Model\ResourceModel\Order\Collection as OrdersCollection;
use Slayer\Test\Model\ResourceModel\Order\CollectionFactory as OrdersCollectionFactory;

/**
 * Class DataProvider
 */
class DataProvider extends AbstractDataProvider
{
    /**
     * @var OrdersCollection
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
     * @param OrdersCollectionFactory $ordersCollectionFactory
     * @param DataPersistorInterface $dataPersistor
     * @param UrlInterface $urlBuilder
     * @param array $meta
     * @param array $data
     */
    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        OrdersCollectionFactory $ordersCollectionFactory,
        DataPersistorInterface $dataPersistor,
        UrlInterface $urlBuilder,
        array $meta = [],
        array $data = []
    ) {
        $this->collection = $ordersCollectionFactory->create();
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
            /** @var OrderInterface $order */
            foreach ($items as $order) {
                $this->loadedData[$order->getId()] = $this->prepareData($order);
            }

            $data = $this->dataPersistor->get('orders');
            if (!empty($data)) {
                $order = $this->collection->getNewEmptyItem();
                $order->setData($data);
                $this->loadedData[$order->getId()] = $this->prepareData($order);
                $this->dataPersistor->clear('orders');
            }
        }

        return $this->loadedData;
    }

    /**
     * @param OrderInterface $order
     * @return array
     */
    private function prepareData($order)
    {
        $data = $order->getData();
        return $data;

        if (isset($data['logo'])) {
            unset($data['logo']);
            $data['logo'][0]['name'] = $car->getData('logo');
            $data['logo'][0]['url'] = $this->getFileUrl($order->getLogo());
        }

        return $data;
    }

    /**
     * @param string $fileName
     * @return string
     */
    private function getFileUrl($fileName)
    {
        return $this->urlBuilder->getBaseUrl(['_type' => UrlInterface::URL_TYPE_MEDIA]) . 'orders/' . $fileName;
    }
}