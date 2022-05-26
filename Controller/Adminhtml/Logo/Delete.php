<?php declare(strict_types=1);

namespace CodingDaniel\LogoManager\Controller\Adminhtml\Logo;

use CodingDaniel\LogoManager\Controller\Adminhtml\Logo;
use Magento\Backend\App\Action\Context;
use Magento\Framework\Registry;
use Psr\Log\LoggerInterface;

class Delete extends Logo
{

    /**
     * @var LoggerInterface
     */
    protected LoggerInterface $_logger;

    /**
     * @param Context $context
     * @param Registry $registry
     * @param \CodingDaniel\LogoManager\Model\Logo $logo
     * @param LoggerInterface $logger
     */
    public function __construct(
        Context $context,
        Registry $registry,
        \CodingDaniel\LogoManager\Model\Logo $logo,
        LoggerInterface $logger
    ) {
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
                $this->messageManager->addSuccessMessage(__('You deleted the logo.'));
                // go to grid
                $this->_redirect('codingdaniel_logomanager/logo/');
                return;
            } catch (\Magento\Framework\Exception\LocalizedException $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
            } catch (\Exception $e) {
                $this->messageManager->addErrorMessage(
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
        $this->messageManager->addErrorMessage(__('We cannot find a logo to delete.'));
        // go to grid
        $this->_redirect('codingdaniel_logomanager/logo/');
    }
}
