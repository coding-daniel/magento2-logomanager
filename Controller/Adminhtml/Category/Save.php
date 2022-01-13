<?php

namespace CodingDaniel\LogoManager\Controller\Adminhtml\Category;

use CodingDaniel\LogoManager\Controller\Adminhtml\Category;

class Save extends Category
{

    /**
     * @var \CodingDaniel\LogoManager\Model\Category
     */
    protected $_category;

    /**
     * @var \CodingDaniel\LogoManager\Model\Category
     */
    protected $_session;

    /**
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Magento\Framework\Registry $registry
     * @param \CodingDaniel\LogoManager\Model\Category $category
     * @param \Magento\Backend\Model\Session $session
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\Registry $registry,
        \CodingDaniel\LogoManager\Model\Category $category,
        \Magento\Backend\Model\Session $session
    ) {
        $this->_session = $session;
        parent::__construct($context, $registry, $category);
    }

    /**
     * @return \Magento\Backend\Model\View\Result\Redirect|\Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {

        $data = $this->getRequest()->getPostValue();
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
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
                    return $resultRedirect->setPath('*/*/edit', ['category_id' => $this->_category->getId(), '_current' => true]);
                }
                return $resultRedirect->setPath('*/*/');
            } catch (\Magento\Framework\Exception\LocalizedException $e) {
                $this->messageManager->addError($e->getMessage());
            } catch (\RuntimeException $e) {
                $this->messageManager->addError($e->getMessage());
            } catch (\Exception $e) {
                $this->messageManager->addException($e, __('Something went wrong while saving the category.'));
            }

            $this->_getSession()->setFormData($data);
            return $resultRedirect->setPath('*/*/edit', ['category_id' => $this->getRequest()->getParam('category_id')]);
        }
        return $resultRedirect->setPath('*/*/');
    }
}
