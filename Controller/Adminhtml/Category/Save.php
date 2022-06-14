<?php declare(strict_types=1);

namespace CodingDaniel\LogoManager\Controller\Adminhtml\Category;

use CodingDaniel\LogoManager\Controller\Adminhtml\Category;
use Magento\Backend\App\Action\Context;
use Magento\Backend\Model\Session;
use Magento\Backend\Model\View\Result\Redirect;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Registry;

class Save extends Category
{

    /**
     * @var \CodingDaniel\LogoManager\Model\Category
     */
    protected \CodingDaniel\LogoManager\Model\Category $_category;

    /**
     * @var \CodingDaniel\LogoManager\Model\Category
     */
    protected $_session;

    /**
     * @param Context $context
     * @param Registry $registry
     * @param \CodingDaniel\LogoManager\Model\Category $category
     * @param Session $session
     */
    public function __construct(
        Context $context,
        Registry $registry,
        \CodingDaniel\LogoManager\Model\Category $category,
        Session $session
    ) {
        $this->_session = $session;
        parent::__construct($context, $registry, $category);
    }

    /**
     * Execute method
     *
     * @return Redirect
     */
    public function execute(): Redirect
    {

        $data = $this->getRequest()->getPostValue();
        /** @var Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        if ($data) {

            $id = $this->getRequest()->getParam('category_id');
            if ($id) {
                $this->_category->load($id);
            }

            $this->_category->setData($data);

            try {
                $this->_category->save();
                $this->messageManager->addSuccess(__('You saved this category.'));
                $this->_session->setFormData(false);
                if ($this->getRequest()->getParam('back')) {
                    return $resultRedirect->setPath(
                        '*/*/edit',
                        ['category_id' => $this->_category->getId(), '_current' => true]
                    );
                }
                return $resultRedirect->setPath('*/*/');
            } catch (LocalizedException|\RuntimeException $e) {
                $this->messageManager->addError($e->getMessage());
            } catch (\Exception $e) {
                $this->messageManager->addException($e, __('Something went wrong while saving the category.'));
            }

            $this->_getSession()->setFormData($data);
            return $resultRedirect->setPath(
                '*/*/edit',
                ['category_id' => $this->getRequest()->getParam('category_id')]
            );
        }
        return $resultRedirect->setPath('*/*/');
    }
}
