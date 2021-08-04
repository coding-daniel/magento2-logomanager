<?php

namespace CodingDaniel\LogoManager\Controller\Adminhtml;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;

abstract class Logo extends Action
{
    const ACTION_RESOURCE = 'CodingDaniel_LogoManager::logo_manager';

    /**
     * Core registry
     *
     * @var \Magento\Framework\Registry
     */
    protected $_registry = null;

    /**
     * @var \CodingDaniel\LogoManager\Model\Logo
     */
    protected $_logo;

    /**
     * LogoManager constructor.
     *
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Magento\Framework\Registry $registry
     * @param \CodingDaniel\LogoManager\Model\Logo
     */
    public function __construct(
        Context $context,
        \Magento\Framework\Registry $registry,
        \CodingDaniel\LogoManager\Model\Logo $logo
    )
    {
        $this->_registry = $registry;
        $this->_logo = $logo;
        parent::__construct($context);
    }

    /**
     * Check the permission to run it.
     *
     * @return bool
     */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed(self::ACTION_RESOURCE);
    }

    /**
     * Load Logo from request
     *
     * @param string $idFieldName
     * @return \CodingDaniel\LogoManager\Model\Logo $model
     */
    protected function _initLogo($idFieldName = 'entity_id')
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
        return (!$model->getId() && $logoId) ? false : true;
    }
}
