<?php

namespace CodingDaniel\LogoManager\Controller\Adminhtml\LogoManager;

use CodingDaniel\LogoManager\Controller\Adminhtml\LogoManager;
use Magento\Framework\App\Action\HttpGetActionInterface as HttpGetActionInterface;

class Index extends LogoManager implements HttpGetActionInterface
{

    /**
     * Logo list
     *
     * @return void
     */
    public function execute()
    {
        $this->_view->loadLayout();
        $this->_setActiveMenu('CodingDaniel_LogoManager::logo_manager');
        $this->_view->getPage()->getConfig()->getTitle()->prepend(__('Manage Logos'));
        $this->_view->renderLayout();
    }
}
