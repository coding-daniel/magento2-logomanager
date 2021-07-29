<?php
namespace CodingDaniel\LogoManager\Model\ResourceModel\Category;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection {

    /**
     * @var string
     */
    protected $_idFieldName = 'category_id';


    protected function _construct() {
        $this->_init('CodingDaniel\LogoManager\Model\Category', 'CodingDaniel\LogoManager\Model\ResourceModel\Category');
    }

}
