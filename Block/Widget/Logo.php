<?php
namespace CodingDaniel\LogoManager\Block\Widget;

use Magento\Framework\View\Element\Template;
use Magento\Widget\Block\BlockInterface;

class Logo extends Template implements BlockInterface {

    protected $_template = "widget/logos.phtml";

    protected $_collection;

    protected $_imageFactory;

    protected $_filesystem;

    /**
     * Constructor
     *
     * @param Template\Context $context
     * @param \CodingDaniel\LogoManager\Model\ResourceModel\Logo\CollectionFactory $collectionFactory
     * @param \Magento\Framework\Image\AdapterFactory $imageFactory
     * @param \Magento\Framework\Filesystem $filesystem
     * @param array $data
     */
    public function __construct(
        Template\Context $context,
        \CodingDaniel\LogoManager\Model\ResourceModel\Logo\CollectionFactory $collectionFactory,
        \Magento\Framework\Image\AdapterFactory $imageFactory,
        \Magento\Framework\Filesystem $filesystem,
        array $data = []
    )
    {
        parent::__construct($context, $data);
        $this->_collection = $collectionFactory;
        $this->_imageFactory = $imageFactory;
        $this->_filesystem = $filesystem;
    }

    public function getLogosCollection($cat = null) {
        $collection = $this->_collection->create();
        $collection->addFieldToFilter('is_enabled', ['eq' => 1]);
        if($cat) $collection->addFieldToFilter('category_select', ['eq' => $cat]);
        return $collection;
    }


    public function resize($image, $width = null, $height = null) {

        $absolutePath = $this->_filesystem->getDirectoryRead(
            \Magento\Framework\App\Filesystem\DirectoryList::MEDIA
            )->getAbsolutePath('logomanager/image/') . $image;
        if (!file_exists($absolutePath)) return false;

        $imageResized = $this->_filesystem->getDirectoryRead(
            \Magento\Framework\App\Filesystem\DirectoryList::MEDIA
            )->getAbsolutePath('logomanager/resized/'.$width.'/') . $image;

        if (!file_exists($imageResized)) { // Only resize image if not already exists.
            //create image factory...
            $imageResize = $this->_imageFactory->create();
            $imageResize->open($absolutePath);
            $imageResize->constrainOnly(true);
            $imageResize->keepTransparency(true);
            $imageResize->keepFrame(false);
            $imageResize->keepAspectRatio(true);
            $imageResize->resize($width,$height);
            //destination folder
            $destination = $imageResized ;
            //save image
            $imageResize->save($destination);
        }

        $resizedURL = $this->_storeManager->getStore()->getBaseUrl(
            \Magento\Framework\UrlInterface::URL_TYPE_MEDIA
            ).'logomanager/resized/'.$width.'/' . $image;

        return $resizedURL;
    }

}
