<?php
namespace CodingDaniel\LogoManager\Block\Widget;

use Magento\Framework\View\Element\Template;
use Magento\Widget\Block\BlockInterface;

class Logo extends Template implements BlockInterface {

    protected $_template = "widget/logos.phtml";

    protected $_collection;

    /**
     * Constructor
     *
     * @param Template\Context $context
     * @param \CodingDaniel\LogoManager\Model\ResourceModel\Logo\CollectionFactory $collectionFactory
     * @param array $data
     */
    public function __construct(
        Template\Context $context,
        \CodingDaniel\LogoManager\Model\ResourceModel\Logo\CollectionFactory $collectionFactory,
        array $data = []
    )
    {
        parent::__construct($context, $data);
        $this->_collection = $collectionFactory;
    }

    public function getLogos($cat = null) {
        $collection = $this->_collection->create();
        $collection->addFieldToFilter('is_enabled', ['eq' => 1]);
        if($cat) $collection->addFieldToFilter('category_select', ['eq' => $cat]);
        return $collection;
    }

}
