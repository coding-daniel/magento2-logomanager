<?php

namespace CodingDaniel\LogoManager\Model\Config\Source;

use Magento\Framework\Data\OptionSourceInterface;
use CodingDaniel\LogoManager\Model\ResourceModel\Category\CollectionFactory;

/**
 * Class WidgetCategory
 */
class SelectCategory implements OptionSourceInterface
{
    /**
     * @var CollectionFactory
     */
    private $category;

    /**
     * WidgetCategory constructor.
     *
     * @param CollectionFactory $category
     */
    public function __construct(
        CollectionFactory $category
    ) {
        $this->category = $category;
    }

    /**
     * Get types as a source model result
     *
     * @param bool $simplified
     * @param bool $withEmpty
     * @return array
     */
    public function toOptionArray($simplified = false, $withEmpty = false)
    {
        $types = $this->getTypes(true, $withEmpty);
        if ($simplified) {
            return $types;
        }
        $result = [];
        foreach ($types as $key => $label) {
            $result[] = ['value' => $key, 'label' => __($label)];
        }
        return $result;
    }

    /**
     *
     * @param bool $sorted
     * @param bool $withEmpty
     * @return array
     */
    public function getTypes($sorted = true, $withEmpty = false)
    {
        $collection = $this->category->create();
        $collection->addFieldToFilter('is_enabled', ['eq' => 1]);

        $result = [];

        foreach ($collection->getItems() as $category) {
            $result[$category->getId()] = __($category->getTitle());
        }
        if ($sorted) {
            asort($result);
        }
        if ($withEmpty) {
            return array_merge(['' => __('-- None --')], $result);
        }
        return $result;
    }

}
