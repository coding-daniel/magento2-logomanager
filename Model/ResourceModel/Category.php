<?php

namespace CodingDaniel\LogoManager\Model\ResourceModel;

class Category extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb {

    /**
     * Category constructor.
     * @param \Magento\Framework\Model\ResourceModel\Db\Context $context
     */
    public function __construct(
        \Magento\Framework\Model\ResourceModel\Db\Context $context
    ) {
        parent::__construct($context);
    }

    protected function _construct() {
        $this->_init('codingdaniel_logomanager_categories', 'category_id');
    }

    /**
     * Retrieves Category Name from DB by id.
     * @param $id
     * @return string
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getCategoryNameById($id)
    {
        $adapter = $this->getConnection();
        $select = $adapter->select()
            ->from($this->getMainTable(), 'title')
            ->where('category_id = :category_id');
        $binds = ['category_id' => (int)$id];

        return $adapter->fetchOne($select, $binds);
    }

}
