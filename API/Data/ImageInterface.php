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

namespace BelSmol\CATAAS\API\Data;

/**
 * Interface DTORequestInterface
 * @package BelSmol\CATAAS\API\Data
 */
interface ImageInterface
{
    /**
     * @return string
     */
    public function getCataasId(): string;

    /**
     * @param string $cataasId
     */
    public function setCataasId(string $cataasId): void;
    /**
     * @return string
     */
    public function getCreatedAt(): string;

    /**
     * @param string $createdAt
     */
    public function setCreatedAt(string $createdAt): void;

    /**
     * @return array
     */
    public function getTags(): array;

    /**
     * @param array $tags
     */
    public function setTags(array $tags = []): void;
    /**
     * @return string
     */
    public function getUrl(): string;

    /**
     * @param string $url
     */
    public function setUrl(string $url = ""): void;
}
