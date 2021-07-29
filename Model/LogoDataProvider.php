<?php

namespace CodingDaniel\LogoManager\Model;

use CodingDaniel\LogoManager\Model\ResourceModel\Logo\CollectionFactory;

class LogoDataProvider extends \Magento\Ui\DataProvider\AbstractDataProvider
{

    /**
     * @var array
     */
    protected $loadedData;

    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        CollectionFactory $logoCollectionFactory,
        array $meta = [],
        array $data = []
    ) {
        $this->collection = $logoCollectionFactory->create();
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
    }

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
