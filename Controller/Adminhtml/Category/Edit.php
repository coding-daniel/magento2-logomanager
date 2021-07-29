<?php

namespace CodingDaniel\LogoManager\Controller\Adminhtml\Category;

use CodingDaniel\LogoManager\Controller\Adminhtml\Category;

class Edit extends Category
{
    /**
     * Edit action
     *
     * @return void
     */
    public function execute()
    {
        $logoId = $this->getRequest()->getParam('category_id');
        $model = $this->_initCategory();

        if (!$model->getId() && $logoId) {
            $this->messageManager->addError(__('This category no longer exists.'));
            $this->_redirect('codingdaniel_logomanager/category/');
            return;
        }

        $data = $this->_getSession()->getFormData(true);
        if (!empty($data)) {
            $model->addData($data);
        }

        $this->_view->loadLayout();
        $this->_setActiveMenu('CodingDaniel_LogoManager::logo_manager_categories');
        $this->_view->getPage()->getConfig()->getTitle()->prepend(__('Categories'));
        $this->_view->getPage()->getConfig()->getTitle()->prepend(
            $model->getId() ? $model->getTitle() : __('New Category')
        );

        $this->_view->renderLayout();
    }
}
