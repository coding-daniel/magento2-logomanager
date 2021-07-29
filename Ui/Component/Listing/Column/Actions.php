<?php

namespace CodingDaniel\LogoManager\Ui\Component\Listing\Column;

class Actions extends \Magento\Ui\Component\Listing\Columns\Column
{
    /**
     * Url path  to edit
     *
     * @var string
     */
    const URL_PATH_EDIT_LOGO = 'codingdaniel_logomanager/logo/edit';

    /**
     * Url path  to delete
     *
     * @var string
     */
    const URL_PATH_DELETE_LOGO = 'codingdaniel_logomanager/logo/delete';

    /**
     * Url path  to edit
     *
     * @var string
     */
    const URL_PATH_EDIT_CAT = 'codingdaniel_logomanager/category/edit';

    /**
     * Url path  to delete
     *
     * @var string
     */
    const URL_PATH_DELETE_CAT = 'codingdaniel_logomanager/category/delete';

    /**
     * URL builder
     *
     * @var \Magento\Framework\UrlInterface
     */
    protected $urlBuilder;

    /**
     * constructor
     *
     * @param \Magento\Framework\UrlInterface $urlBuilder
     * @param \Magento\Framework\View\Element\UiComponent\ContextInterface $context
     * @param \Magento\Framework\View\Element\UiComponentFactory $uiComponentFactory
     * @param array $components
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\UrlInterface $urlBuilder,
        \Magento\Framework\View\Element\UiComponent\ContextInterface $context,
        \Magento\Framework\View\Element\UiComponentFactory $uiComponentFactory,
        array $components = [],
        array $data = []
    ) {

        $this->urlBuilder = $urlBuilder;
        parent::__construct($context, $uiComponentFactory, $components, $data);
    }


    /**
     * Prepare Data Source
     *
     * @param array $dataSource
     * @return array
     */
    public function prepareDataSource(array $dataSource)
    {
        if (isset($dataSource['data']['items'])) {
            foreach ($dataSource['data']['items'] as & $item) {
                if (isset($item['entity_id'])) {
                    $item[$this->getData('name')] = [
                        'edit'   => [
                            'href'  => $this->urlBuilder->getUrl(
                                static::URL_PATH_EDIT_LOGO,
                                [
                                    'entity_id' => $item['entity_id']
                                ]
                            ),
                            'label' => __('Edit')
                        ],
                        'delete' => [
                            'href'    => $this->urlBuilder->getUrl(
                                static::URL_PATH_DELETE_LOGO,
                                [
                                    'entity_id' => $item['entity_id']
                                ]
                            ),
                            'label'   => __('Delete'),
                            'confirm' => [
                                'title'   => __('Delete Logo'),
                                'message' => __('Are you sure you want to delete the selected logo?')
                            ]
                        ]
                    ];
                } elseif (isset($item['category_id'])) {
                    $item[$this->getData('name')] = [
                        'edit'   => [
                            'href'  => $this->urlBuilder->getUrl(
                                static::URL_PATH_EDIT_CAT,
                                [
                                    'category_id' => $item['category_id']
                                ]
                            ),
                            'label' => __('Edit')
                        ],
                        'delete' => [
                            'href'    => $this->urlBuilder->getUrl(
                                static::URL_PATH_DELETE_CAT,
                                [
                                    'category_id' => $item['category_id']
                                ]
                            ),
                            'label'   => __('Delete'),
                            'confirm' => [
                                'title'   => __('Delete Logo'),
                                'message' => __('Are you sure you want to delete the selected logo?')
                            ]
                        ]
                    ];
                }
            }
        }

        return $dataSource;
    }
}
