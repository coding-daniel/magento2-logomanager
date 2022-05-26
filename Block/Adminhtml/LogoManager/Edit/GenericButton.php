<?php declare(strict_types=1);

namespace CodingDaniel\LogoManager\Block\Adminhtml\LogoManager\Edit;

use CodingDaniel\LogoManager\Model\LogoFactory;
use CodingDaniel\LogoManager\Model\ResourceModel\Logo;
use Magento\Framework\UrlInterface;
use Magento\Framework\App\RequestInterface;

/**
 * Class for common code for buttons on the create/edit logo form
 */
class GenericButton
{
    /**
     * @var LogoFactory
     */
    private $logoFactory;

    /**
     * @var Logo
     */
    private $logoResourceModel;

    /**
     * @var UrlInterface
     */
    private $urlBuilder;

    /**
     * @var RequestInterface
     */
    private $request;

    /**
     * @param UrlInterface $urlBuilder
     * @param RequestInterface $request
     * @param LogoFactory $logoFactory
     * @param Logo $logoResourceModel
     */
    public function __construct(
        UrlInterface $urlBuilder,
        RequestInterface $request,
        LogoFactory $logoFactory,
        Logo $logoResourceModel
    ) {
        $this->urlBuilder = $urlBuilder;
        $this->request = $request;
        $this->logoFactory = $logoFactory;
        $this->logoResourceModel = $logoResourceModel;
    }

    /**
     * Return logo id
     *
     * @return int|null
     */
    public function getLogoId()
    {
        $logo = $this->logoFactory->create();

        $this->logoResourceModel->load(
            $logo,
            $this->request->getParam('entity_id')
        );

        return $logo->getLogoId() ?: null;
    }

    /**
     * Generate url by route and parameters
     *
     * @param   string $route
     * @param   array $params
     * @return  string
     */
    public function getUrl($route = '', $params = [])
    {
        return $this->urlBuilder->getUrl($route, $params);
    }
}
