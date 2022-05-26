<?php declare(strict_types=1);

namespace CodingDaniel\LogoManager\Controller\Adminhtml\Logo;

use CodingDaniel\LogoManager\Controller\Adminhtml\Logo;
use CodingDaniel\LogoManager\Model\Image;
use Magento\Backend\App\Action\Context;
use Magento\Backend\Model\Session;
use Magento\Backend\Model\View\Result\Redirect;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Registry;

class Save extends Logo
{
    /**
     * @var Image
     */
    protected Image $imageUploader;

    /**
     * @var \CodingDaniel\LogoManager\Model\Logo
     */
    protected \CodingDaniel\LogoManager\Model\Logo $_logo;

    /**
     * @var Session
     */
    protected $_session;

    /**
     * @param Context $context
     * @param Image $image
     * @param Registry $registry
     * @param \CodingDaniel\LogoManager\Model\Logo $logo
     * @param Session $session
     */
    public function __construct(
        Context $context,
        Image $image,
        Registry $registry,
        \CodingDaniel\LogoManager\Model\Logo $logo,
        Session $session
    ) {
        $this->imageUploader = $image;
        $this->_logo = $logo;
        $this->_session = $session;
        parent::__construct($context, $registry, $logo);
    }

    /**
     * Execute method
     *
     * @return Redirect
     * @throws LocalizedException
     */
    public function execute(): Redirect
    {

        $data = $this->getRequest()->getPostValue();

        /** @var Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();

        if ($data) {

            if (isset($data['desktop_logo_image'][0]['name']) &&
                isset($data['desktop_logo_image'][0]['tmp_name'])
            ) {
                $data['desktop_logo_image'] = $data['desktop_logo_image'][0]['name'];
                $this->imageUploader->moveFileFromTmp($data['desktop_logo_image']);
            } elseif (isset($data['desktop_logo_image'][0]['name']) &&
                !isset($data['desktop_logo_image'][0]['tmp_name'])
            ) {
                $data['desktop_logo_image'] = $data['desktop_logo_image'][0]['name'];
            } else {
                $data['desktop_logo_image'] = '';
            }

            if (isset($data['mobile_logo_image'][0]['name']) &&
                isset($data['mobile_logo_image'][0]['tmp_name'])
            ) {
                $data['mobile_logo_image'] = $data['mobile_logo_image'][0]['name'];
                $this->imageUploader->moveFileFromTmp($data['mobile_logo_image']);
            } elseif (isset($data['mobile_logo_image'][0]['name']) &&
                !isset($data['mobile_logo_image'][0]['tmp_name'])
            ) {
                $data['mobile_logo_image'] = $data['mobile_logo_image'][0]['name'];
            } else {
                $data['mobile_logo_image'] = '';
            }

            $id = $this->getRequest()->getParam('entity_id');
            if ($id) {
                $this->_logo->load($id);
            }

            $this->_logo->setData($data);

            try {
                $this->_logo->save();
                $this->messageManager->addSuccessMessage(__('You saved this Logo.'));
                $this->_session->setFormData(false);
                if ($this->getRequest()->getParam('back')) {
                    return $resultRedirect->setPath(
                        '*/*/edit',
                        ['entity_id' => $this->_logo->getId(), '_current' => true]
                    );
                }
                return $resultRedirect->setPath('*/*/');
            } catch (LocalizedException|\RuntimeException $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
            } catch (\Exception $e) {
                $this->messageManager->addExceptionMessage($e, __('Something went wrong while saving the logo.'));
            }

            $this->_getSession()->setFormData($data);
            return $resultRedirect->setPath('*/*/edit', ['entity_id' => $this->getRequest()->getParam('entity_id')]);
        }
        return $resultRedirect->setPath('*/*/');
    }
}
