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

namespace BelSmol\CATAAS\Model\Http;

use BelSmol\CATAAS\API\Data\DTOResponseInterface;
use BelSmol\CATAAS\API\Data\DTOResponseInterfaceFactory;
use BelSmol\CATAAS\API\DTOResponseMapperInterface;

/**
 * Class DTOResponseMapper
 * @package BelSmol\CATAAS\Model\Http
 */
class DTOResponseMapper implements DTOResponseMapperInterface
{
    private DTOResponseInterfaceFactory $dtoResponseFactory;

    /**
     * @param DTOResponseInterfaceFactory $dtoResponseFactory
     */
    public function __construct(DTOResponseInterfaceFactory $dtoResponseFactory)
    {
        $this->dtoResponseFactory = $dtoResponseFactory;
    }

    /**
     * @param int $statusCode
     * @param array $response
     * @return DTOResponseInterface
     */
    public function map(int $statusCode, array $response): DTOResponseInterface
    {
        $responseObject = $this->dtoResponseFactory->create();
        $responseObject->setStatus($statusCode);
        $responseObject->setData((array)$response);
        return $responseObject;
    }
}
