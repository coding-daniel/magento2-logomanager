<?php declare(strict_types=1);

namespace CodingDaniel\LogoManager\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class Logo extends AbstractDb
{
    /**
     * Class construct
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('codingdaniel_logomanager_logos', 'entity_id');
    }
}
