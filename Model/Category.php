<?php declare(strict_types=1);

namespace CodingDaniel\LogoManager\Model;

use Magento\Framework\DataObject\IdentityInterface;
use Magento\Framework\Model\AbstractModel;

class Category extends AbstractModel implements IdentityInterface
{

    public const CACHE_TAG = 'codingdaniel_logomanager_categories';

    /**
     * Class construct
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init(ResourceModel\Category::class);
    }

    /**
     * Identities
     *
     * @return array|string[]
     */
    public function getIdentities(): array
    {
        return [self::CACHE_TAG . '_' . $this->getId()];
    }
}
