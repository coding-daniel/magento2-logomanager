<?php

namespace CodingDaniel\LogoManager\Model;

class Logo extends \Magento\Framework\Model\AbstractModel implements \Magento\Framework\DataObject\IdentityInterface {

    const CACHE_TAG = 'codingdaniel_logomanager_logo';

    protected function _construct() {
        $this->_init('CodingDaniel\LogoManager\Model\ResourceModel\Logo');
    }

    public function getIdentities() {
        return [self::CACHE_TAG . '_' . $this->getId()];
    }

//    /**
//     * @return ResourceModel\Category\Collection
//     */
//    public function getSelectedCategoriesCollection()
//    {
//        if ($this->categoryCollection === null) {
//            $collection = $this->categoryCollectionFactory->create();
//            $collection->join(
//                $this->getResource()->getTable('mageplaza_blog_post_category'),
//                'main_table.category_id=' . $this->getResource()->getTable('mageplaza_blog_post_category') .
//                '.category_id AND ' . $this->getResource()->getTable('mageplaza_blog_post_category') . '.post_id="'
//                . $this->getId() . '"',
//                ['position']
//            );
//            $this->categoryCollection = $collection;
//        }
//
//        return $this->categoryCollection;
//    }
//
//    /**
//     * @return array
//     * @throws LocalizedException
//     */
//    public function getCategoryIds()
//    {
//        if (!$this->hasData('category_ids')) {
//            $ids = $this->_getResource()->getCategoryIds($this);
//            $this->setData('category_ids', $ids);
//        }
//
//        return (array) $this->_getData('category_ids');
//    }
//
//    /**
//     * @return mixed
//     * @throws NoSuchEntityException
//     */
//    public function getUrlImage()
//    {
//        $imageHelper = $this->helperData->getImageHelper();
//        $imageFile   = $this->getImage() ? $imageHelper->getMediaPath($this->getImage(), 'post') : '';
//        $imageUrl    = $imageFile ? $this->helperData->getImageHelper()->getMediaUrl($imageFile) : '';
//
//        $this->setData('image', $imageUrl);
//        return $this->_getData('image');
//    }

}
