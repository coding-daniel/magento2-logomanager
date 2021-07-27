<?php

namespace CodingDaniel\LogoManager\Block\Adminhtml\LogoManager\Edit;

use Magento\Framework\View\Element\UiComponent\Control\ButtonProviderInterface;

/**
 * Class for "Delete" button on the create/edit logo form
 */
class DeleteButton extends GenericButton implements ButtonProviderInterface
{

    public function getButtonData()
    {
        $data = [];
        if ($this->getLogoId()) {
            $data = [
                'label' => __('Delete'),
                'class' => 'delete',
                'on_click' => 'deleteConfirm(\'' . __(
                        'Are you sure you want to do this?'
                    ) . '\', \'' . $this->getDeleteUrl() . '\')',
                'sort_order' => 20,
            ];
        }
        return $data;
    }

    public function getDeleteUrl()
    {
        return $this->getUrl('*/*/delete', ['entity_id' => $this->getLogoId()]);
    }
}
