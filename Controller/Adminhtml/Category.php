<?php

namespace CodingDaniel\LogoManager\Controller\Adminhtml;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;

abstract class Category extends Action
{
    const ACTION_RESOURCE = 'CodingDaniel_LogoManager::logo_manager_categories';

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
     * @return \CodingDaniel\LogoManager\Model\Category $model
     */
    protected function _initCategory($idFieldName = 'category_id')
    {
        $categoryId = (int)$this->getRequest()->getParam($idFieldName);

        $model = $this->_objectManager->create(\CodingDaniel\LogoManager\Model\Category::class);

        if ($categoryId) {
            $model->load($categoryId);
        }

        if (!$this->_registry->registry('current_category')) {
            $this->_registry->register('current_category', $model);
        }
        return $model;
    }
}
