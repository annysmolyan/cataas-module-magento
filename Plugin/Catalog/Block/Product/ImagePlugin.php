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

namespace BelSmol\CATAAS\Plugin\Catalog\Block\Product;

use Magento\Catalog\Block\Product\Image as Subject;
use Magento\Framework\App\Request\Http;
use BelSmol\CATAAS\API\ImageManagerInterface;
use BelSmol\CATAAS\Helper\ConfigHelper;

/**
 * Class ImagePlugin
 * @package BelSmol\CATAAS\Plugin\Catalog\Block\Product
 */
class ImagePlugin
{
    private const SUBJECT_DATA_KEY = "image_url";

    private array $allowedActions = [
        "catalog_category_view",
        "catalog_product_view"
    ];

    private ImageManagerInterface $cataasImageManager;
    private ConfigHelper $configHelper;
    private Http $httpRequest;

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
     * Replace product listing image with CATAAS img
     * DONT USER RETURN TYPE and TYPE HINT HERE!
     *
     * @param Subject $subject
     * @param $result
     * @param $key
     * @param $index
     * @return mixed|string
     */
    public function afterGetData(Subject $subject, $result, $key, $index)
    {
        if ($this->isPluginAllowed((string)$key)) {
            $image = $this->cataasImageManager->getImageWithText();
            $result = $image->getUrl() ?? $result; // return initial value if api returned error
        }

        return $result;
    }

    /**
     * @param string $key
     * @return bool
     */
    private function isPluginAllowed(string $key): bool
    {
        return $this->isActionAllowed() &&
            ($key == self::SUBJECT_DATA_KEY)
            && $this->configHelper->moduleEnabled();
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
