<?php

namespace Eleanorsoft\Instagram\Instagram\Api\Adapter\Cosenary\Instagram;

use \Exception;
use \Magento\Framework\Url as UrlHelper;

/**
 * Class ImageAdapter
 * Adapter for Instagram image.
 *
 * @author Eugene Polischuk <eugene.polischuk@eleanorsoft.com>
 * @copyright Copyright (c) 2017 Eleanorsoft (https://www.eleanorsoft.com/)
 */
class ImageAdapter
{
    /**
     * Image url property.
     */
    const PROPERTY_URL = 'url';

    /**
     * Image width property.
     */
    const PROPERTY_WIDTH = 'width';

    /**
     * Image height property.
     */
    const PROPERTY_HEIGHT = 'height';

    /**
     * Resource image.
     *
     * @var mixed
     */
    private $resource;

    /**
     * Get image resource.
     *
     * @return mixed
     * @throws Exception
     * @author Eugene Polischuk <eugene.polischuk@eleanorsoft.com>
     */
    public function getResource()
    {
        if (!$this->resource) {
            throw new Exception('Source image is not set.');
        }

        return $this->resource;
    }

    /**
     * Set image resource.
     *
     * @param $resource
     * @author Eugene Polischuk <eugene.polischuk@eleanorsoft.com>
     */
    public function setResource($resource)
    {
        $this->resource = $resource;
    }

    /**
     * Get image link.
     *
     * @return string
     * @author Eugene Polischuk <eugene.polischuk@eleanorsoft.com>
     */
    public function getLink()
    {
        return $this->getResource()->link;
    }

    /**
     * Get thumbnail type.
     *
     * @return string
     * @author Eugene Polischuk <eugene.polischuk@eleanorsoft.com>
     */
    public function getThumbnailType()
    {
        return 'thumbnail';
    }

    /**
     * Get low resolution type.
     *
     * @return string
     * @author Eugene Polischuk <eugene.polischuk@eleanorsoft.com>
     */
    public function getLowResolutionType()
    {
        return 'low_resolution';
    }

    /**
     * Get standard resolution type.
     *
     * @return string
     * @author Eugene Polischuk <eugene.polischuk@eleanorsoft.com>
     */
    public function getStandardResolutionType()
    {
        return 'standard_resolution';
    }

    /**
     * Get thumbnail url.
     *
     * @return string
     * @author Eugene Polischuk <eugene.polischuk@eleanorsoft.com>
     */
    public function getThumbnailUrl()
    {
        return $this->getSourceImageData($this->getThumbnailType(), self::PROPERTY_URL);
    }

    /**
     * Get low resolution url.
     *
     * @return string
     * @author Eugene Polischuk <eugene.polischuk@eleanorsoft.com>
     */
    public function getLowResolutionUrl()
    {
        return $this->getSourceImageData($this->getLowResolutionType(), self::PROPERTY_URL);
    }

    /**
     * Get standard resolution url.
     *
     * @return string
     * @author Eugene Polischuk <eugene.polischuk@eleanorsoft.com>
     */
    public function getStandardResolutionUrl()
    {
        return $this->getSourceImageData($this->getStandardResolutionType(), self::PROPERTY_URL);
    }

    /**
     * Get thumbnail height.
     *
     * @return string
     * @author Eugene Polischuk <eugene.polischuk@eleanorsoft.com>
     */
    public function getThumbnailHeight()
    {
        return $this->getSourceImageData($this->getThumbnailType(), self::PROPERTY_HEIGHT);
    }

    /**
     * Get low resolution height.
     *
     * @return string
     * @author Eugene Polischuk <eugene.polischuk@eleanorsoft.com>
     */
    public function getLowResolutionHeight()
    {
        return $this->getSourceImageData($this->getLowResolutionType(), self::PROPERTY_HEIGHT);
    }

    /**
     * Get standard resolution height.
     *
     * @return string
     * @author Eugene Polischuk <eugene.polischuk@eleanorsoft.com>
     */
    public function getStandardResolutionHeight()
    {
        return $this->getSourceImageData($this->getStandardResolutionType(), self::PROPERTY_HEIGHT);
    }

    /**
     * Get thumbnail width.
     *
     * @return string
     * @author Eugene Polischuk <eugene.polischuk@eleanorsoft.com>
     */
    public function getThumbnailWidth()
    {
        return $this->getSourceImageData($this->getThumbnailType(), self::PROPERTY_WIDTH);
    }

    /**
     * Get low resolution width.
     *
     * @return string
     * @author Eugene Polischuk <eugene.polischuk@eleanorsoft.com>
     */
    public function getLowResolutionWidth()
    {
        return $this->getSourceImageData($this->getLowResolutionType(), self::PROPERTY_WIDTH);
    }

    /**
     * Get standard resolution width.
     *
     * @return string
     * @author Eugene Polischuk <eugene.polischuk@eleanorsoft.com>
     */
    public function getStandardResolutionWidth()
    {
        return $this->getSourceImageData($this->getStandardResolutionType(), self::PROPERTY_WIDTH);
    }

    /**
     * Get source image data.
     *
     * @param $type
     * @param $property
     * @return string
     * @author Eugene Polischuk <eugene.polischuk@eleanorsoft.com>
     */
    private function getSourceImageData($type, $property)
    {
        return $this->getResource()->images->{$type}->{$property};
    }
}
