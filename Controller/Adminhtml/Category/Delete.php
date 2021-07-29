<?php

namespace CodingDaniel\LogoManager\Controller\Adminhtml\Category;

use CodingDaniel\LogoManager\Controller\Adminhtml\Category;

class Delete extends Category
{
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
                // init model and delete
                $model = $this->_objectManager->create(\CodingDaniel\LogoManager\Model\Category::class);
                $model->load($logoId);
                $model->delete();
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
                $this->_objectManager->get(\Psr\Log\LoggerInterface::class)->critical($e);
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
