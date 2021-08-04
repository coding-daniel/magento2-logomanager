<?php

namespace CodingDaniel\LogoManager\Controller\Adminhtml\Logo;

use CodingDaniel\LogoManager\Controller\Adminhtml\Logo;

class Delete extends Logo
{

    /**
     * @var \Psr\Log\LoggerInterface
     */
    protected $_logger;

    /**
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Magento\Framework\Registry $registry
     * @param \CodingDaniel\LogoManager\Model\Logo
     * @param \Psr\Log\LoggerInterface $logger
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\Registry $registry,
        \CodingDaniel\LogoManager\Model\Logo $logo,
        \Psr\Log\LoggerInterface $logger
    )
    {
        $this->_registry = $registry;
        $this->_logo = $logo;
        $this->_logger = $logger;
        parent::__construct($context, $registry, $logo);
    }


    /**
     * Delete action
     *
     * @return void
     */
    public function execute()
    {
        // check if we know what should be deleted
        $logoId = $this->getRequest()->getParam('entity_id');
        if ($logoId) {
            try {
                $this->_logo->load($logoId);
                $this->_logo->delete();
                // display success message
                $this->messageManager->addSuccess(__('You deleted the logo.'));
                // go to grid
                $this->_redirect('codingdaniel_logomanager/logo/');
                return;
            } catch (\Magento\Framework\Exception\LocalizedException $e) {
                $this->messageManager->addError($e->getMessage());
            } catch (\Exception $e) {
                $this->messageManager->addError(
                    __(
                        'Something went wrong while deleting the logo data. '
                        . 'Please review the action log and try again.'
                    )
                );
                $this->_logger->critical($e);
                // save data in session
                $this->_getSession()->setFormData($this->getRequest()->getParams());
                // redirect to edit form
                $this->_redirect('codingdaniel_logomanager/logo/edit', ['entity_id' => $logoId]);
                return;
            }
        }
        // display error message
        $this->messageManager->addError(__('We cannot find a logo to delete.'));
        // go to grid
        $this->_redirect('codingdaniel_logomanager/logo/');
    }
}
