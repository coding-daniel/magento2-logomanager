<?php declare(strict_types=1);

namespace CodingDaniel\LogoManager\Model\ResourceModel\Category;

use CodingDaniel\LogoManager\Model\ResourceModel\Category;
use CodingDaniel\LogoManager\Model\Category as ModelCategory;
use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{

    /**
     * @var string
     */
    protected $_idFieldName = 'category_id';

    /**
     * Class construct
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init(
            ModelCategory::class,
            Category::class
        );
    }
}
