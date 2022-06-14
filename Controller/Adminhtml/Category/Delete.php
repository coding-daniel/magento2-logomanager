<?php declare(strict_types=1);

namespace CodingDaniel\LogoManager\Controller\Adminhtml\Category;

use CodingDaniel\LogoManager\Controller\Adminhtml\Category;
use Magento\Backend\App\Action\Context;
use Magento\Framework\Registry;
use Psr\Log\LoggerInterface;

class Delete extends Category
{

    /**
     * @var \CodingDaniel\LogoManager\Model\Category
     */
    protected \CodingDaniel\LogoManager\Model\Category $_category;

    /**
     * @var LoggerInterface
     */
    protected LoggerInterface $_logger;

    /**
     * Delete constructor.
     * @param Context $context
     * @param Registry $registry
     * @param \CodingDaniel\LogoManager\Model\Category $category
     * @param LoggerInterface $logger
     */
    public function __construct(
        Context $context,
        Registry $registry,
        \CodingDaniel\LogoManager\Model\Category $category,
        LoggerInterface $logger
    ) {
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
                $this->messageManager->addSuccessMessage(__('You deleted the category.'));
                // go to grid
                $this->_redirect('codingdaniel_logomanager/category/');
                return;
            } catch (\Magento\Framework\Exception\LocalizedException $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
            } catch (\Exception $e) {
                $this->messageManager->addErrorMessage(
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
        $this->messageManager->addErrorMessage(__('We cannot find a category to delete.'));
        // go to grid
        $this->_redirect('codingdaniel_logomanager/category/');
    }
}
