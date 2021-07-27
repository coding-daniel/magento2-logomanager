<?php

namespace CodingDaniel\LogoManager\Model;

class Logo extends \Magento\Framework\Model\AbstractModel implements \Magento\Framework\DataObject\IdentityInterface {

    const CACHE_TAG = 'codingdaniel_logomanager_logos';

    protected function _construct() {
        $this->_init('CodingDaniel\LogoManager\Model\ResourceModel\Logo');
    }

    public function getIdentities() {
        return [self::CACHE_TAG . '_' . $this->getId()];
    }

}
