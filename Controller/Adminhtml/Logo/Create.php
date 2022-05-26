<?php declare(strict_types=1);

namespace CodingDaniel\LogoManager\Controller\Adminhtml\Logo;

use CodingDaniel\LogoManager\Controller\Adminhtml\Logo;

class Create extends Logo
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
