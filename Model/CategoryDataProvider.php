<?php

namespace CodingDaniel\LogoManager\Model;

use CodingDaniel\LogoManager\Model\ResourceModel\Category\CollectionFactory;

class CategoryDataProvider extends \Magento\Ui\DataProvider\AbstractDataProvider
{

    /**
     * @var array
     */
    protected $loadedData;

    /**
     * CategoryDataProvider constructor.
     * @param $name
     * @param $primaryFieldName
     * @param $requestFieldName
     * @param CollectionFactory $categoryCollectionFactory
     * @param array $meta
     * @param array $data
     */
    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        CollectionFactory $categoryCollectionFactory,
        array $meta = [],
        array $data = []
    ) {
        $this->collection = $categoryCollectionFactory->create();
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
    }

    /**
     * @return array
     */
    public function getData()
    {
        if (isset($this->loadedData)) {
            return $this->loadedData;
        }

        $items = $this->collection->getItems();

        foreach ($items as $item) {
            $item->load($item->getId());

            $this->loadedData[$item->getId()] = $item->getData();
        }


        return $this->loadedData;

    }
}
