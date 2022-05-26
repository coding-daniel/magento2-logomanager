<?php declare(strict_types=1);

namespace CodingDaniel\LogoManager\Controller\Adminhtml;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\Registry;

abstract class Logo extends Action
{
    public const ACTION_RESOURCE = 'CodingDaniel_LogoManager::logo_manager';

    /**
     * @var Registry|null
     */
    protected ?Registry $_registry = null;

    /**
     * @var \CodingDaniel\LogoManager\Model\Logo
     */
    protected \CodingDaniel\LogoManager\Model\Logo $_logo;

    /**
     * @param Context $context
     * @param Registry $registry
     * @param \CodingDaniel\LogoManager\Model\Logo $logo
     */
    public function __construct(
        Context $context,
        Registry $registry,
        \CodingDaniel\LogoManager\Model\Logo $logo
    ) {
        $this->_registry = $registry;
        $this->_logo = $logo;
        parent::__construct($context);
    }

    /**
     * Check the permission to run it.
     *
     * @return bool
     */
    protected function _isAllowed(): bool
    {
        return $this->_authorization->isAllowed(self::ACTION_RESOURCE);
    }

    /**
     * Load Logo from request
     *
     * @param string $idFieldName
     * @return \CodingDaniel\LogoManager\Model\Logo $model
     */
    protected function _initLogo(string $idFieldName = 'entity_id'): \CodingDaniel\LogoManager\Model\Logo
    {
        $logoId = (int)$this->getRequest()->getParam($idFieldName);

        if ($logoId) {
            $this->_logo->load($logoId);
        }

        if (!$this->_registry->registry('current_logo')) {
            $this->_registry->register('current_logo', $this->_logo);
        }
        return $this->_logo;
    }

    /**
     * Check if logo exist
     *
     * @param \CodingDaniel\LogoManager\Model\Logo $model
     * @return bool
     */
    protected function isLogoExist(\CodingDaniel\LogoManager\Model\Logo $model)
    {
        $logoId = $this->getRequest()->getParam('entity_id');
        return !((!$model->getId() && $logoId));
    }
}
