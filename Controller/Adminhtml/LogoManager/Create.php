<?php

namespace CodingDaniel\LogoManager\Controller\Adminhtml\LogoManager;

use CodingDaniel\LogoManager\Controller\Adminhtml\LogoManager;

class Create extends LogoManager
{
    /**
     * Create new logo
     *
     * @return void
     */
    public function execute()
    {
        // the same form is used to create and edit
        $this->_forward('edit');
    }
}
