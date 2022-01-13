<?php

namespace CodingDaniel\LogoManager\Model\ResourceModel;

class Logo extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb {

    /**
     * Logo constructor.
     * @param \Magento\Framework\Model\ResourceModel\Db\Context $context
     */
    public function __construct(
        \Magento\Framework\Model\ResourceModel\Db\Context $context
    ) {
        parent::__construct($context);
    }

    protected function _construct() {
        $this->_init('codingdaniel_logomanager_logos', 'entity_id');
    }

}
