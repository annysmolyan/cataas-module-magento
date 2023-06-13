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

namespace BelSmol\CATAAS\API;

use BelSmol\CATAAS\API\Data\DTOResponseInterface;

/**
 * Interface DTOResponseMapperInterface
 * @package BelSmol\CATAAS\API
 */
interface DTOResponseMapperInterface
{
    public function map(int $statusCode, array $response): DTOResponseInterface;
}
