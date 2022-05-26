<?php declare(strict_types=1);

namespace CodingDaniel\LogoManager\Model;

use CodingDaniel\LogoManager\Model\ResourceModel\Category\CollectionFactory;
use Magento\Ui\DataProvider\AbstractDataProvider;

class CategoryDataProvider extends AbstractDataProvider
{

    /**
     * @var array
     */
    protected array $loadedData;

    /**
     * CategoryDataProvider constructor.
     * @param string $name
     * @param string $primaryFieldName
     * @param string $requestFieldName
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
     * Data
     *
     * @return array
     */
    public function getData(): array
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
