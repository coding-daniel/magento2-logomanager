<?php declare(strict_types=1);

namespace CodingDaniel\LogoManager\Model;

use Magento\Framework\DataObject\IdentityInterface;
use Magento\Framework\Model\AbstractModel;

class Logo extends AbstractModel implements IdentityInterface
{

    public const CACHE_TAG = 'codingdaniel_logomanager_logo';

    /**
     * Construct
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init(CodingDaniel\LogoManager\Model\ResourceModel\Logo::class);
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
