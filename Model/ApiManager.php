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

use BelSmol\CATAAS\API\ApiManagerInterface;
use BelSmol\CATAAS\API\Data\DTOResponseInterface;
use BelSmol\CATAAS\API\EndpointRepositoryInterface;
use BelSmol\CATAAS\API\Data\DTORequestInterfaceFactory;
use BelSmol\CATAAS\API\HttpClientInterface;

/**
 * Class ApiManager
 * @package BelSmol\CATAAS\Model
 */
class ApiManager implements ApiManagerInterface
{
    private EndpointRepositoryInterface $endpointRepository;
    private DTORequestInterfaceFactory $dtoRequestFactory;
    private HttpClientInterface $httpClient;

    /**
     * @param EndpointRepositoryInterface $cataasEndpointRepository
     * @param DTORequestInterfaceFactory $httpRequestFactory
     * @param HttpClientInterface $httpClient
     */
    public function __construct(
        EndpointRepositoryInterface $cataasEndpointRepository,
        DTORequestInterfaceFactory $httpRequestFactory,
        HttpClientInterface $httpClient
    ) {
        $this->endpointRepository = $cataasEndpointRepository;
        $this->dtoRequestFactory = $httpRequestFactory;
        $this->httpClient = $httpClient;
    }

    /**
     * @return DTOResponseInterface
     */
    public function callImage(): DTOResponseInterface
    {
        $httpRequest = $this->dtoRequestFactory->create();
        $endpoint = $this->endpointRepository->getImageJsonEndpoint();
        $httpRequest->setEndpoint($endpoint);

        return $this->httpClient->call($httpRequest);
    }
}
