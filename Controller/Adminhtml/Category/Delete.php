<?php

namespace CodingDaniel\LogoManager\Controller\Adminhtml\Category;

use CodingDaniel\LogoManager\Controller\Adminhtml\Category;
use Magento\Backend\App\Action\Context;

class Delete extends Category
{

    /**
     * @var \CodingDaniel\LogoManager\Model\Category
     */
    protected $_category;

    /**
     * @var \Psr\Log\LoggerInterface
     */
    protected $_logger;

    public function __construct(
        Context $context,
        \Magento\Framework\Registry $registry,
        \CodingDaniel\LogoManager\Model\Category $category,
        \Psr\Log\LoggerInterface $logger
    )
    {
        $this->_category = $category;
        $this->_logger = $logger;
        parent::__construct($context, $registry, $category);
    }

    /**
     * Delete action
     *
     * @return void
     */
    public function execute()
    {
        // check if we know what should be deleted
        $logoId = $this->getRequest()->getParam('category_id');
        if ($logoId) {
            try {
                $this->_category->load($logoId);
                $this->_category->delete();
                // display success message
                $this->messageManager->addSuccess(__('You deleted the category.'));
                // go to grid
                $this->_redirect('codingdaniel_logomanager/category/');
                return;
            } catch (\Magento\Framework\Exception\LocalizedException $e) {
                $this->messageManager->addError($e->getMessage());
            } catch (\Exception $e) {
                $this->messageManager->addError(
                    __(
                        'Something went wrong while deleting the category data. '
                        . 'Please review the action log and try again.'
                    )
                );
                $this->_logger->critical($e);
                // save data in session
                $this->_getSession()->setFormData($this->getRequest()->getParams());
                // redirect to edit form
                $this->_redirect('codingdaniel_logomanager/category/edit', ['category_id' => $logoId]);
                return;
            }
        }
        // display error message
        $this->messageManager->addError(__('We cannot find a category to delete.'));
        // go to grid
        $this->_redirect('codingdaniel_logomanager/category/');
    }
}
