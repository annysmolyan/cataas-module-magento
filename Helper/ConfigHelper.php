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

namespace BelSmol\CATAAS\Helper;

use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Store\Model\ScopeInterface;

/**
 * Class ConfigHelper
 * @package BelSmol\CATAAS\Helper
 */
class ConfigHelper extends AbstractHelper
{
    const CONFIG_ENABLED_PATH = "cataas/general/enabled";
    const CONFIG_CATS_TEXT = "cataas/front_settings/cat_text";
    const CONFIG_API_HOST = "cataas/api_settings/api_host";

    /**
     * @return bool
     */
    public function moduleEnabled(): bool
    {
        return $this->scopeConfig->isSetFlag(self::CONFIG_ENABLED_PATH, ScopeInterface::SCOPE_STORE);
    }

    /**
     * @return string
     */
    public function getCatText(): string
    {
        return (string)$this->scopeConfig->getValue(
            self::CONFIG_CATS_TEXT,
            ScopeInterface::SCOPE_STORE
        );
    }

    /**
     * @return string
     */
    public function getApiHost(): string
    {
        return (string)$this->scopeConfig->getValue(
            self::CONFIG_API_HOST,
            ScopeInterface::SCOPE_STORE
        );
    }
}
