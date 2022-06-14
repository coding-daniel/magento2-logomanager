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
    private LogoFactory $logoFactory;

    /**
     * @var Logo
     */
    private Logo $logoResourceModel;

    /**
     * @var UrlInterface
     */
    private UrlInterface $urlBuilder;

    /**
     * @var RequestInterface
     */
    private RequestInterface $request;

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
    public function getLogoId(): ?int
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
     * @param string $route
     * @param array $params
     * @return string
     */
    public function getUrl(string $route = '', array $params = []): string
    {
        return $this->urlBuilder->getUrl($route, $params);
    }
}
