<?php declare(strict_types=1);

namespace CodingDaniel\LogoManager\Controller\Adminhtml\Category;

use CodingDaniel\LogoManager\Controller\Adminhtml\Category;

class Create extends Category
{
    /**
     * Create new category
     *
     * @return void
     */
    public function execute()
    {
        // the same form is used to create and edit
        $this->_forward('edit');
    }
}
