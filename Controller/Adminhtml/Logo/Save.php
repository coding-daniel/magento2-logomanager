<?php

namespace CodingDaniel\LogoManager\Controller\Adminhtml\Logo;

use CodingDaniel\LogoManager\Controller\Adminhtml\Logo;
use CodingDaniel\LogoManager\Model\Image;

class Save extends Logo
{

    protected $imageUploader;

    /**
     * @param \Magento\Backend\App\Action\Context $context
     * @param \CodingDaniel\LogoManager\Model\Image
     * @param \Magento\Framework\Registry $registry
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        Image $image,
        \Magento\Framework\Registry $registry
    ) {
        $this->imageUploader = $image;
        parent::__construct($context, $registry);
    }

    public function execute()
    {

        $data = $this->getRequest()->getPostValue();

        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();

        if ($data) {

            if (
                isset($data['desktop_logo_image'][0]['name']) &&
                isset($data['desktop_logo_image'][0]['tmp_name'])
            ) {
                $data['desktop_logo_image'] = $data['desktop_logo_image'][0]['name'];
                $this->imageUploader->moveFileFromTmp($data['desktop_logo_image']);
            } elseif (
                isset($data['desktop_logo_image'][0]['name']) &&
                !isset($data['desktop_logo_image'][0]['tmp_name'])
            ) {
                $data['desktop_logo_image'] = $data['desktop_logo_image'][0]['name'];
            } else {
                $data['desktop_logo_image'] = '';
            }

            if (
                isset($data['mobile_logo_image'][0]['name']) &&
                isset($data['mobile_logo_image'][0]['tmp_name'])
            ) {
                $data['mobile_logo_image'] = $data['mobile_logo_image'][0]['name'];
                $this->imageUploader->moveFileFromTmp($data['mobile_logo_image']);
            } elseif (
                isset($data['mobile_logo_image'][0]['name']) &&
                !isset($data['mobile_logo_image'][0]['tmp_name'])
            ) {
                $data['mobile_logo_image'] = $data['mobile_logo_image'][0]['name'];
            } else {
                $data['mobile_logo_image'] = '';
            }


            $model = $this->_objectManager->create('CodingDaniel\LogoManager\Model\Logo');

            $id = $this->getRequest()->getParam('entity_id');
            if ($id) {
                $model->load($id);
            }

            $model->setData($data);

            try {
                $model->save();
                $this->messageManager->addSuccess(__('You saved this Logo.'));
                $this->_objectManager->get('Magento\Backend\Model\Session')->setFormData(false);
                if ($this->getRequest()->getParam('back')) {
                    return $resultRedirect->setPath('*/*/edit', ['entity_id' => $model->getId(), '_current' => true]);
                }
                return $resultRedirect->setPath('*/*/');
            } catch (\Magento\Framework\Exception\LocalizedException $e) {
                $this->messageManager->addError($e->getMessage());
            } catch (\RuntimeException $e) {
                $this->messageManager->addError($e->getMessage());
            } catch (\Exception $e) {
                $this->messageManager->addException($e, __('Something went wrong while saving the logo.'));
            }

            $this->_getSession()->setFormData($data);
            return $resultRedirect->setPath('*/*/edit', ['entity_id' => $this->getRequest()->getParam('entity_id')]);
        }
        return $resultRedirect->setPath('*/*/');
    }
}
