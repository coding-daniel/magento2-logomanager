<?php

namespace CodingDaniel\LogoManager\Controller\Adminhtml\Category;

use CodingDaniel\LogoManager\Controller\Adminhtml\Category;
use Magento\Framework\App\Action\HttpGetActionInterface as HttpGetActionInterface;

class Index extends Category implements HttpGetActionInterface
{

    /**
     * Logo list
     *
     * @return void
     */
    public function execute()
    {
        $this->_view->loadLayout();
        $this->_setActiveMenu('CodingDaniel_LogoManager::logo_manager_categories');
        $this->_view->getPage()->getConfig()->getTitle()->prepend(__('Categories'));
        $this->_view->renderLayout();
    }
}
