<?php declare(strict_types=1);

namespace CodingDaniel\LogoManager\Block\Widget;

use CodingDaniel\LogoManager\Model\ResourceModel\Logo\Collection;
use CodingDaniel\LogoManager\Model\ResourceModel\Logo\CollectionFactory;
use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Filesystem;
use Magento\Framework\Image\AdapterFactory;
use Magento\Framework\UrlInterface;
use Magento\Framework\View\Element\Template;
use Magento\Widget\Block\BlockInterface;

class Logo extends Template implements BlockInterface
{

    /**
     * @var string
     */
    protected $_template = "widget/logos.phtml";

    /**
     * @var CollectionFactory
     */
    protected CollectionFactory $_collection;

    /**
     * @var AdapterFactory
     */
    protected AdapterFactory $_imageFactory;

    /**
     * @var Filesystem
     */
    protected $_filesystem;

    /**
     * Logo constructor.
     * @param Template\Context $context
     * @param CollectionFactory $collectionFactory
     * @param AdapterFactory $imageFactory
     * @param Filesystem $filesystem
     * @param array $data
     */
    public function __construct(
        Template\Context $context,
        CollectionFactory $collectionFactory,
        AdapterFactory $imageFactory,
        Filesystem $filesystem,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->_collection = $collectionFactory;
        $this->_imageFactory = $imageFactory;
        $this->_filesystem = $filesystem;
    }

    /**
     * Get logos
     *
     * @param string|null $cat
     * @return Collection
     */
    public function getLogosCollection(string $cat = null): Collection
    {
        $collection = $this->_collection->create();
        $collection->addFieldToFilter('is_enabled', ['eq' => 1]);
        if ($cat) {
            $collection->addFieldToFilter('category_select', ['eq' => $cat]);
        }
        return $collection;
    }

    /**
     * Resize images
     *
     * @param string $image
     * @param string|null $width
     * @param string|null $height
     * @return false|string
     * @throws NoSuchEntityException
     */
    public function resize(string $image, string $width = null, string $height = null)
    {
        $absolutePath = $this->_filesystem
                ->getDirectoryRead(DirectoryList::MEDIA)
                ->getAbsolutePath('logomanager/image/') . $image;
        if (!file_exists($absolutePath)) {
            return false;
        }

        $imageResized = $this->_filesystem
                ->getDirectoryRead(DirectoryList::MEDIA)
                ->getAbsolutePath('logomanager/resized/' . $width . '/') . $image;

        // Only resize image if not already exists.
        if (!file_exists($imageResized)) {
            //create image factory...
            $imageResize = $this->_imageFactory->create();
            $imageResize->open($absolutePath);
            $imageResize->constrainOnly(true);
            $imageResize->keepTransparency(true);
            $imageResize->keepFrame(false);
            $imageResize->keepAspectRatio(true);
            $imageResize->resize($width, $height);
            //destination folder
            $destination = $imageResized;
            //save image
            $imageResize->save($destination);
        }

        return $this->_storeManager->getStore()->getBaseUrl(
            UrlInterface::URL_TYPE_MEDIA
        ) . 'logomanager/resized/' . $width . '/' . $image;
    }
}
