<?php
/**
 * NOTICE OF LICENSE
 *
 * This source file is subject to the GNU General Public License v3 (GPL 3.0)
 * It is also available through the world-wide-web at this URL:
 * https://www.gnu.org/licenses/gpl-3.0.en.html
 *
 * @category BelSmol
 * @package BelSmol_CATAAS
 * @license https://www.gnu.org/licenses/gpl-3.0.en.html GNU General Public License v3 (GPL 3.0)
 */

namespace BelSmol\CATAAS\Plugin\Swatches\Controller\Ajax;

use Magento\Catalog\Model\Product\Attribute\Source\Status;
use Magento\Catalog\Model\ProductFactory;
use Magento\Framework\App\Request\Http;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Swatches\Controller\Ajax\Media as Subject;
use Magento\Swatches\Helper\Data;
use BelSmol\CATAAS\API\ImageManagerInterface;
use BelSmol\CATAAS\Helper\ConfigHelper;

/**
 * Class MediaPlugin
 * @package BelSmol\CATAAS\Plugin\Swatches\Controller\Ajax
 */
class MediaPlugin
{
    private ImageManagerInterface $cataasImageManager;
    private ConfigHelper $configHelper;
    private Data $swatchHelper;
    private Http $httpRequest;
    private ProductFactory $productModelFactory;

    /**
     * @param ImageManagerInterface $cataasImageManager
     * @param ConfigHelper $configHelper
     * @param Data $swatchHelper
     * @param Http $httpRequest
     * @param ProductFactory $productModelFactory
     */
    public function __construct(
        ImageManagerInterface $cataasImageManager,
        ConfigHelper $configHelper,
        Data $swatchHelper,
        Http $httpRequest,
        ProductFactory $productModelFactory
    ) {
        $this->cataasImageManager = $cataasImageManager;
        $this->configHelper = $configHelper;
        $this->swatchHelper = $swatchHelper;
        $this->httpRequest = $httpRequest;
        $this->productModelFactory = $productModelFactory;
    }

    /**
     * Replace swatches images with CATAAS on category_view page
     */
    public function aroundExecute(Subject $subject, callable $proceed): ResultInterface
    {
        $result = $proceed();

        if ($this->configHelper->moduleEnabled()) {
            $resultData = $this->getGalleryWithCataasImgs();
            $result->setData($resultData);
        }

        return $result;
    }

    /**
     * Override initial functionality of the controller
     *
     * @return array
     * @throws LocalizedException
     */
    private function getGalleryWithCataasImgs(): array
    {
        $productMedia = [];

        if ($productId = (int)$this->httpRequest->getParam('product_id')) {
            $product = $this->productModelFactory->create()->load($productId);

            if ($product->getId() && $product->getStatus() == Status::STATUS_ENABLED) {
                $productMediaData = $this->swatchHelper->getProductMediaGallery($product);

                //>>> upd start
                $cataasImage = $this->cataasImageManager->getImageWithText();
                $productMediaData["large"] = $cataasImage->getUrl();
                $productMediaData["medium"] = $cataasImage->getUrl();
                $productMediaData["small"] = $cataasImage->getUrl();
                //<<< upd end
                $productMedia = $productMediaData;
            }
        }

        return $productMedia;
    }
}
