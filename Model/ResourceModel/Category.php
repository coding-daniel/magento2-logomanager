<?php declare(strict_types=1);

namespace CodingDaniel\LogoManager\Model\ResourceModel;

use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class Category extends AbstractDb
{

    /**
     * Class construct
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('codingdaniel_logomanager_categories', 'category_id');
    }

    /**
     * Retrieves Category Name from DB by id.
     *
     * @param string $id
     * @return string
     * @throws LocalizedException
     */
    public function getCategoryNameById(string $id): string
    {
        $adapter = $this->getConnection();
        $select = $adapter->select()
            ->from($this->getMainTable(), 'title')
            ->where('category_id = :category_id');
        $binds = ['category_id' => (int)$id];

        return $adapter->fetchOne($select, $binds);
    }
}
