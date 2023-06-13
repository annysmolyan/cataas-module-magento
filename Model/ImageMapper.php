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

use BelSmol\CATAAS\API\Data\ImageInterface;
use BelSmol\CATAAS\API\Data\DTOResponseInterface;
use BelSmol\CATAAS\API\Data\ImageInterfaceFactory;
use BelSmol\CATAAS\API\ImageMapperInterface;
use BelSmol\CATAAS\Helper\ConfigHelper;

/**
 * Class ImageMapper
 * @package BelSmol\CATAAS\Model
 */
class ImageMapper implements ImageMapperInterface
{
    protected const ID_KEY = "id";
    protected const CREATED_KEY = "created_at";
    protected const TAGS_KEY = "tags";
    protected const URL_KEY = "url";
    protected const HTTP_OK = 200;

    private ImageInterfaceFactory $imageFactory;
    private ConfigHelper $configHelper;

    /**
     * @param ConfigHelper $configHelper
     * @param ImageInterfaceFactory $imageFactory
     */
    public function __construct(
        ConfigHelper $configHelper,
        ImageInterfaceFactory $imageFactory
    ) {
        $this->imageFactory = $imageFactory;
        $this->configHelper = $configHelper;
    }

    /**
     * Map common info with Image object.
     * Don't add extra parameters to url here.
     * Use Image Manager and particular method for that.
     *
     * @param DTOResponseInterface $DTOResponse
     * @return ImageInterface
     */
    public function map(DTOResponseInterface $DTOResponse): ImageInterface
    {
        $entity = $this->imageFactory->create();

        if ($DTOResponse->getStatus() == self::HTTP_OK) {
            $responseData = $DTOResponse->getData();

            $cataasId = $this->getStringData($responseData, self::ID_KEY);
            $entity->setCataasId($cataasId);

            $createdAt = $this->getStringData($responseData, self::CREATED_KEY);
            $entity->setCreatedAt($createdAt);

            $tags = $responseData[self::TAGS_KEY] ?? [];
            $entity->setTags($tags);

            $url = $responseData[self::URL_KEY] ? $this->configHelper->getApiHost() . $responseData[self::URL_KEY] : "";
            $entity->setUrl($url);
        }

        return $entity;
    }

    /**
     * @param array $data
     * @param string $key
     * @return string
     */
    private function getStringData(array $data, string $key): string
    {
        return $data[$key] ?? "";
    }
}
