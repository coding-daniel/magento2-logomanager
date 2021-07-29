<?php

namespace CodingDaniel\LogoManager\Controller\Adminhtml\Category;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Backend\Model\View\Result\Redirect;

use CodingDaniel\LogoManager\Model\ResourceModel\Category\CollectionFactory;

use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Exception\NotFoundException;
use Magento\Ui\Component\MassAction\Filter;

class MassDelete extends Action implements HttpPostActionInterface
{
    /**
     * Authorization level
     */
    const ADMIN_RESOURCE = 'CodingDaniel_LogoManager::logo_manager_categories';

    /**
     * @var \CodingDaniel\LogoManager\Model\ResourceModel\Category\CollectionFactory
     */
    protected $collectionFactory;


    /**
     * @var \Magento\Ui\Component\MassAction\Filter
     */
    protected $filter;

    /**
     * Constructor
     *
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Magento\Ui\Component\MassAction\Filter $filter
     * @param \CodingDaniel\LogoManager\Model\ResourceModel\Category\CollectionFactory $collectionFactory
     */
    public function __construct(
        Context $context,
        Filter $filter,
        CollectionFactory $collectionFactory
    ) {
        $this->filter = $filter;
        $this->collectionFactory = $collectionFactory;
        parent::__construct($context);
    }

    public function execute(): Redirect
    {
        if (!$this->getRequest()->isPost()) {
            throw new NotFoundException(__('Logo not found'));
        }
        $collection = $this->filter->getCollection($this->collectionFactory->create());
        $logoDeleted = 0;
        foreach ($collection->getItems() as $logo) {
            $logo->delete();
            $logoDeleted++;
        }

        if ($logoDeleted) {
            $this->messageManager->addSuccessMessage(
                __('A total of %1 record(s) have been deleted.', $logoDeleted)
            );
        }
        return $this->resultFactory->create(ResultFactory::TYPE_REDIRECT)->setPath('codingdaniel_logomanager/category/index');
    }

}
