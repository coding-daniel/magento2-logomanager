<?php declare(strict_types=1);

namespace CodingDaniel\LogoManager\Block\Adminhtml\LogoManager\Edit;

use Magento\Framework\View\Element\UiComponent\Control\ButtonProviderInterface;

class DeleteButton extends GenericButton implements ButtonProviderInterface
{

    /**
     * Get Data
     *
     * @return array
     */
    public function getButtonData(): array
    {
        $data = [];
        if ($this->getLogoId()) {
            $data = [
                'label' => __('Delete'),
                'class' => 'delete',
                'on_click' => 'deleteConfirm(\'' .
                    __('Are you sure you want to do this?') .
                    '\', \'' . $this->getDeleteUrl() . '\')',
                'sort_order' => 20,
            ];
        }
        return $data;
    }

    /**
     * Delete URL
     *
     * @return string
     */
    public function getDeleteUrl(): string
    {
        return $this->getUrl('*/*/delete', ['entity_id' => $this->getLogoId()]);
    }
}
