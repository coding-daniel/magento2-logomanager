<?php

namespace CodingDaniel\LogoManager\Model;

use CodingDaniel\LogoManager\Model\ResourceModel\Logo\CollectionFactory;
use Magento\Store\Model\StoreManagerInterface;

class LogoDataProvider extends \Magento\Ui\DataProvider\AbstractDataProvider
{

    /**
     * @var array
     */
    protected $loadedData;

    /**
     * Store manager
     *
     * @var StoreManagerInterface
     */
    protected $storeManager;

    protected $_mediaUrl;

    /**
     * LogoDataProvider constructor.
     * @param string $name
     * @param string $primaryFieldName
     * @param string $requestFieldName
     * @param CollectionFactory $logoCollectionFactory
     * @param StoreManagerInterface $storeManager
     * @param array $meta
     * @param array $data
     * @throws \Magento\Framework\Exception\NoSuchEntityException
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
        $this->_mediaUrl = $this->storeManager->getStore()->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA);;
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
    }

    /**
     * @return array
     */
    public function getData()
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
