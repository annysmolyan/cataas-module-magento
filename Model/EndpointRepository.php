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

namespace BelSmol\CATAAS\Model;

use BelSmol\CATAAS\API\EndpointRepositoryInterface;
use BelSmol\CATAAS\Helper\ConfigHelper;

/**
 * Class EndpointRepository
 * Endpoint storage. Can be modified and added new endpoints (get without saying and so on)
 * @package BelSmol\CATAAS\Model
 */
class EndpointRepository implements EndpointRepositoryInterface
{
    private ConfigHelper $configHelper;

    /**
     * @param ConfigHelper $configHelper
     */
    public function __construct(ConfigHelper $configHelper)
    {
        $this->configHelper = $configHelper;
    }

    /**
     * @return string
     */
    public function getImageJsonEndpoint(): string
    {
        return $this->getApiUrl() . "?text=" . $this->configHelper->getCatText(). "&json=true";
    }

    /**
     * @return string
     */
    protected function getApiUrl(): string
    {
        return $this->configHelper->getApiHost() . "cat";
    }
}
