<?php

namespace CodingDaniel\LogoManager\Controller\Adminhtml;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;

abstract class LogoManager extends Action
{
    const ACTION_RESOURCE = 'CodingDaniel_LogoManager::logo_manager';

    /**
     * Core registry
     *
     * @var \Magento\Framework\Registry
     */
    protected $_registry = null;

    /**
     * LogoManager constructor.
     *
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Magento\Framework\Registry $registry
     */
    public function __construct(
        Context $context,
        \Magento\Framework\Registry $registry
    )
    {
        $this->_registry = $registry;
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

        $model = $this->_objectManager->create(\CodingDaniel\LogoManager\Model\Logo::class);

        if ($logoId) {
            $model->load($logoId);
        }

        if (!$this->_registry->registry('current_logo')) {
            $this->_registry->register('current_logo', $model);
        }
        return $model;
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
