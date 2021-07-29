<?php

namespace CodingDaniel\LogoManager\Model;

class Category extends \Magento\Framework\Model\AbstractModel implements \Magento\Framework\DataObject\IdentityInterface {

    const CACHE_TAG = 'codingdaniel_logomanager_categories';

    protected function _construct() {
        $this->_init('CodingDaniel\LogoManager\Model\ResourceModel\Category');
    }

    public function getIdentities() {
        return [self::CACHE_TAG . '_' . $this->getId()];
    }

}
