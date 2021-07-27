<?php
namespace CodingDaniel\LogoManager\Model\ResourceModel\Logo;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection {

    /**
     * @var string
     */
    protected $_idFieldName = 'entity_id';


    protected function _construct() {
        $this->_init('CodingDaniel\LogoManager\Model\Logo', 'CodingDaniel\LogoManager\Model\ResourceModel\Logo');
    }

}
