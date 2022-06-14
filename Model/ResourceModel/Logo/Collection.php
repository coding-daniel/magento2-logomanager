<?php declare(strict_types=1);

namespace CodingDaniel\LogoManager\Model\ResourceModel\Logo;

use CodingDaniel\LogoManager\Model\ResourceModel\Logo;
use CodingDaniel\LogoManager\Model\Logo as ModelLogo;
use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{

    /**
     * @var string
     */
    protected $_idFieldName = 'entity_id';

    /**
     * Class construct
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init(
            ModelLogo::class,
            Logo::class
        );
    }
}
