<?php declare(strict_types=1);

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
    private CollectionFactory $category;

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
    public function toOptionArray(bool $simplified = false, bool $withEmpty = false): array
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
     * Types
     *
     * @param bool $sorted
     * @param bool $withEmpty
     * @return array
     */
    public function getTypes(bool $sorted = true, bool $withEmpty = false): array
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
