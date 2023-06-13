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

namespace BelSmol\CATAAS\Plugin\Catalog\Block\Product\View;

use Magento\Catalog\Block\Product\View\Gallery as Subject;
use Magento\Framework\App\Request\Http;
use BelSmol\CATAAS\API\ImageManagerInterface;
use BelSmol\CATAAS\Helper\ConfigHelper;

/**
 * Class GalleryPlugin
 * @package BelSmol\CATAAS\Plugin\Catalog\Block\Product\View
 */
class GalleryPlugin
{
    private ImageManagerInterface $cataasImageManager;
    private ConfigHelper $configHelper;
    private Http $httpRequest;

    private array $allowedActions = [
        "catalog_category_view",
        "catalog_product_view"
    ];

    /**
     * @param ImageManagerInterface $cataasImageManager
     * @param ConfigHelper $configHelper
     * @param Http $httpRequest
     */
    public function __construct(
        ImageManagerInterface $cataasImageManager,
        ConfigHelper $configHelper,
        Http $httpRequest
    ) {
        $this->cataasImageManager = $cataasImageManager;
        $this->configHelper = $configHelper;
        $this->httpRequest = $httpRequest;
    }

    /**
     * Replace product gallery with CATAAS images (except for configurable images)
     * DONT USE RETURN TYPE HERE
     */
    public function afterGetGalleryImages(Subject $subject, $result)
    {
        if (!$this->isPluginAllowed()) {
            return $result;
        }

        foreach ($result as $item) {
            $image = $item->getUrl();

            // magento request twice getGalleryImage method, need to check did we replace image,
            // and if so, anyway update object with already assigned cataas img, otherwise get new img
            // and update items
            if (!$this->isCataasImage($image)) {
                $imageObject = $this->cataasImageManager->getImageWithText();
                $image = $imageObject->getUrl();
            }

            $item->setSmallImageUrl($image);
            $item->setMediumImageUrl($image);
            $item->setLargeImageUrl($image);
            $item->setUrl($image);
        }

        return $result;
    }

    /**
     * @param string $imgUrl
     * @return bool
     */
    private function isCataasImage(string $imgUrl): bool
    {
        $position = strpos($imgUrl, $this->configHelper->getApiHost());
        return $position !== false;
    }

    /**
     * @return bool
     */
    private function isPluginAllowed(): bool
    {
        return $this->isActionAllowed() && $this->configHelper->moduleEnabled();
    }

    /**
     * @return bool
     */
    private function isActionAllowed(): bool
    {
        $currentFullAction = $this->httpRequest->getFullActionName();
        return in_array($currentFullAction, $this->allowedActions);
    }
}
