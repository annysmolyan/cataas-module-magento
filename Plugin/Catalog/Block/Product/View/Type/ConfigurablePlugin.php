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

namespace BelSmol\CATAAS\Plugin\Catalog\Block\Product\View\Type;

use Magento\ConfigurableProduct\Block\Product\View\Type\Configurable as Subject;
use Magento\Framework\App\Request\Http;
use BelSmol\CATAAS\API\ImageManagerInterface;
use BelSmol\CATAAS\Helper\ConfigHelper;

/**
 * Class ConfigurablePlugin
 * @package BelSmol\CATAAS\Plugin\Catalog\Block\Product\View\Type
 */
class ConfigurablePlugin
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
     * Replace product gallery with CATAAS for configurable options on product view page
     * @param Subject $subject
     * @param string|null $result
     * @return string
     */
    public function afterGetJsonConfig(Subject $subject, ?string $result): string
    {
        if (!$this->isPluginAllowed()) {
            return $result;
        }

        $decodedResult = json_decode($result);
        $imagesOptions = $decodedResult->images;

        foreach ($imagesOptions as $optionImages) {
            foreach ($optionImages as $optionImage) {
                $cataasImage = $this->cataasImageManager->getImageWithText();
                $optionImage->thumb = $cataasImage->getUrl();
                $optionImage->img = $cataasImage->getUrl();
                $optionImage->full = $cataasImage->getUrl();
            }
        }
        return json_encode($decodedResult);
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
