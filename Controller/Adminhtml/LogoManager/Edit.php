<?php

namespace CodingDaniel\LogoManager\Controller\Adminhtml\LogoManager;

use CodingDaniel\LogoManager\Controller\Adminhtml\LogoManager;

class Edit extends LogoManager
{
    /**
     * Edit action
     *
     * @return void
     */
    public function execute()
    {
        $logoId = $this->getRequest()->getParam('entity_id');
        $model = $this->_initLogo();

        if (!$model->getId() && $logoId) {
            $this->messageManager->addError(__('This logo no longer exists.'));
            $this->_redirect('codingdaniel/logomanager/');
            return;
        }

        $data = $this->_getSession()->getFormData(true);
        if (!empty($data)) {
            $model->addData($data);
        }

        $this->_view->loadLayout();
        $this->_setActiveMenu('CodingDaniel_LogoManager::logo_manager');
        $this->_view->getPage()->getConfig()->getTitle()->prepend(__('Manage Logos'));
        $this->_view->getPage()->getConfig()->getTitle()->prepend(
            $model->getId() ? $model->getTitle() : __('New Logo')
        );

        $this->_view->renderLayout();
    }
}
