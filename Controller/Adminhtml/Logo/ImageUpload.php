<?php declare(strict_types=1);

namespace CodingDaniel\LogoManager\Controller\Adminhtml\Logo;

use CodingDaniel\LogoManager\Model\Image;
use CodingDaniel\LogoManager\Model\ResourceModel\Logo\CollectionFactory;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Controller\ResultInterface;
use Magento\Ui\Component\MassAction\Filter;

class ImageUpload extends Action implements HttpPostActionInterface
{
    /**
     * Authorization level
     */
    public const ADMIN_RESOURCE = 'CodingDaniel_LogoManager::logo_manager';

    /**
     * @var Image $imageUploader
     */
    protected Image $imageUploader;

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
     * @param Image $image
     */
    public function __construct(
        Context $context,
        Image $image
    ) {
        $this->imageUploader = $image;
        parent::__construct($context);
    }

    /**
     * Execute method
     *
     * @return ResponseInterface|ResultInterface
     */
    public function execute()
    {
        $imageId = $this->_request->getParam('param_name', 'image');

        try {
            $result = $this->imageUploader->saveFileToTmpDir($imageId);
        } catch (\Exception $e) {
            $result = ['error' => $e->getMessage(), 'errorcode' => $e->getCode()];
        }
        return $this->resultFactory->create(ResultFactory::TYPE_JSON)->setData($result);
    }
}
