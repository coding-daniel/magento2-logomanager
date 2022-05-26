<?php declare(strict_types=1);

namespace CodingDaniel\LogoManager\Controller\Adminhtml;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\Registry;

abstract class Category extends Action
{
    public const ACTION_RESOURCE = 'CodingDaniel_LogoManager::logo_manager_categories';

    /**
     * @var Registry|null
     */
    protected ?Registry $_registry = null;

    /**
     * @var \CodingDaniel\LogoManager\Model\Category
     */
    protected \CodingDaniel\LogoManager\Model\Category $_category;

    /**
     * @param Context $context
     * @param Registry $registry
     * @param \CodingDaniel\LogoManager\Model\Category $category
     */
    public function __construct(
        Context $context,
        Registry $registry,
        \CodingDaniel\LogoManager\Model\Category $category
    ) {
        $this->_category = $category;
        $this->_registry = $registry;
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
     * @return \CodingDaniel\LogoManager\Model\Category $model
     */
    protected function _initCategory(string $idFieldName = 'category_id'): \CodingDaniel\LogoManager\Model\Category
    {
        $categoryId = (int)$this->getRequest()->getParam($idFieldName);

        if ($categoryId) {
            $this->_category->load($categoryId);
        }

        if (!$this->_registry->registry('current_category')) {
            $this->_registry->register('current_category', $this->_category);
        }
        return $this->_category;
    }
}
