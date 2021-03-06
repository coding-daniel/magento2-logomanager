<?php declare(strict_types=1);

namespace CodingDaniel\LogoManager\Controller\Adminhtml\Logo;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Backend\Model\View\Result\Redirect;

use CodingDaniel\LogoManager\Model\ResourceModel\Logo\CollectionFactory;

use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NotFoundException;
use Magento\Ui\Component\MassAction\Filter;

class MassDelete extends Action implements HttpPostActionInterface
{
    /**
     * Authorization level
     */
    public const ADMIN_RESOURCE = 'CodingDaniel_LogoManager::logo_manager';

    /**
     * @var CollectionFactory
     */
    protected CollectionFactory $collectionFactory;


    /**
     * @var Filter
     */
    protected Filter $filter;

    /**
     * Constructor
     *
     * @param Context $context
     * @param Filter $filter
     * @param CollectionFactory $collectionFactory
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

    /**
     * Execute method
     *
     * @return Redirect
     * @throws NotFoundException
     * @throws LocalizedException
     */
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
        return $this->resultFactory->create(ResultFactory::TYPE_REDIRECT)
            ->setPath('codingdaniel_logomanager/logo/index');
    }
}
