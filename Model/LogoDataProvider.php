<?php declare(strict_types=1);

namespace CodingDaniel\LogoManager\Model;

use CodingDaniel\LogoManager\Model\ResourceModel\Logo\CollectionFactory;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Ui\DataProvider\AbstractDataProvider;

class LogoDataProvider extends AbstractDataProvider
{

    /**
     * @var array
     */
    protected array $loadedData;

    /**
     * Store manager interface
     *
     * @var StoreManagerInterface
     */
    protected StoreManagerInterface $storeManager;

    /**
     * @var string
     */
    protected string $_mediaUrl;

    /**
     * LogoDataProvider constructor.
     * @param string $name
     * @param string $primaryFieldName
     * @param string $requestFieldName
     * @param CollectionFactory $logoCollectionFactory
     * @param StoreManagerInterface $storeManager
     * @param array $meta
     * @param array $data
     * @throws NoSuchEntityException
     */
    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        CollectionFactory $logoCollectionFactory,
        StoreManagerInterface $storeManager,
        array $meta = [],
        array $data = []
    ) {
        $this->collection = $logoCollectionFactory->create();
        $this->storeManager = $storeManager;
        $this->_mediaUrl = $this->storeManager->getStore()->getBaseUrl(
            \Magento\Framework\UrlInterface::URL_TYPE_MEDIA
        );
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
    }

    /**
     * Data
     *
     * @return array
     */
    public function getData(): array
    {
        if (isset($this->loadedData)) {
            return $this->loadedData;
        }

        $items = $this->collection->getItems();

        foreach ($items as $item) {
            $_data = $item->getData();

            if (isset($_data['desktop_logo_image'])) {

                $image = [];
                $image[0]['name'] = $_data['desktop_logo_image'];
                $image[0]['url'] = $this->_mediaUrl.'logomanager/image/'.$_data['desktop_logo_image'];
                $_data['desktop_logo_image'] = $image;

            }

            if (isset($_data['mobile_logo_image'])) {

                $image = [];
                $image[0]['name'] = $_data['mobile_logo_image'];
                $image[0]['url'] = $this->_mediaUrl.'logomanager/image/'.$_data['mobile_logo_image'];
                $_data['mobile_logo_image'] = $image;

            }

            $item->setData($_data);

            $this->loadedData[$item->getId()] = $item->getData();

        }

        return $this->loadedData;
    }
}
