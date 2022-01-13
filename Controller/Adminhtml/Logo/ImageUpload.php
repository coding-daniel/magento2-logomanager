<?php

namespace CodingDaniel\LogoManager\Controller\Adminhtml\Logo;

use CodingDaniel\LogoManager\Model\Image;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\Controller\ResultFactory;

class ImageUpload extends Action implements HttpPostActionInterface
{
    /**
     * Authorization level
     */
    const ADMIN_RESOURCE = 'CodingDaniel_LogoManager::logo_manager';

    /**
     * Image uploader
     *
     * @var \CodingDaniel\LogoManager\Model\Image $imageUploader
     */
    protected $imageUploader;

    /**
     * @var \CodingDaniel\LogoManager\Model\ResourceModel\Logo\CollectionFactory
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
     * @param \CodingDaniel\LogoManager\Model\Image $image
     */
    public function __construct(
        Context $context,
        Image $image
    ) {
        $this->imageUploader = $image;
        parent::__construct($context);
    }

    /**
     * @return \Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\ResultInterface
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
