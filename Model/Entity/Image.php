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

namespace BelSmol\CATAAS\Model\Entity;

use BelSmol\CATAAS\API\Data\ImageInterface;

/**
 * Class Image
 * @package BelSmol\CATAAS\Model\Entity
 */
class Image implements ImageInterface
{
    private string $cataasId;
    private string $createdAt = "";
    private array $tags = [];
    private string $url = "";

    /**
     * @return string
     */
    public function getCataasId(): string
    {
        return $this->cataasId;
    }

    /**
     * @param string $cataasId
     */
    public function setCataasId(string $cataasId): void
    {
        $this->cataasId = $cataasId;
    }

    /**
     * @return string
     */
    public function getCreatedAt(): string
    {
        return $this->createdAt;
    }

    /**
     * @param string $createdAt
     */
    public function setCreatedAt(string $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    /**
     * @return array
     */
    public function getTags(): array
    {
        return $this->tags;
    }

    /**
     * @param array $tags
     */
    public function setTags(array $tags = []): void
    {
        $this->tags = $tags;
    }

    /**
     * @return string
     */
    public function getUrl(): string
    {
        return $this->url;
    }

    /**
     * @param string $url
     */
    public function setUrl(string $url = ""): void
    {
        $this->url = $url;
    }
}
