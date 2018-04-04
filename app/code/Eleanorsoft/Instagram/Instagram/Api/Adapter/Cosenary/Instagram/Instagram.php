<?php

namespace Eleanorsoft\Instagram\Instagram\Api\Adapter\Cosenary\Instagram;

use \MetzWeb\Instagram\Instagram as MetzWebInstagram;
use \Eleanorsoft\Instagram\Helper\Config as ModuleConfig;
use \Eleanorsoft\Instagram\Instagram\Api\Adapter\AdapterInterface;

/**
 * Class Instagram
 * Adapter for Cosenary library.
 *
 * @author Eugene Polischuk <eugene.polischuk@eleanorsoft.com>
 * @copyright Copyright (c) 2017 Eleanorsoft (https://www.eleanorsoft.com/)
 */
class Instagram implements AdapterInterface
{
    /**
     * @var ModuleConfig
     */
    protected $moduleConfig;

    /**
     * Service instance.
     *
     * @var MetzWebInstagram
     */
    private static $serviceInstance;

    /**
     * Instagram constructor.
     *
     * @param ModuleConfig $moduleConfig
     * @author Eugene Polischuk <eugene.polischuk@eleanorsoft.com>
     */
    public function __construct(
        ModuleConfig $moduleConfig
    ) {
        $this->moduleConfig = $moduleConfig;
    }

    /**
     * Get service instance.
     *
     * @return MetzWebInstagram
     * @author Eugene Polischuk <eugene.polischuk@eleanorsoft.com>
     */
    public function getServiceInstance()
    {
        if (!isset(self::$serviceInstance)) {
            self::$serviceInstance = new MetzWebInstagram([
                'apiKey' => $this->moduleConfig->getClientIdValue(),
                'apiSecret' => $this->moduleConfig->getClientSecretValue(),
                'apiCallback' => $this->moduleConfig->getApiCallbackUrl()
            ]);
        }

        return self::$serviceInstance;
    }

    /**
     * Get login url.
     *
     * @return string
     * @author Eugene Polischuk <eugene.polischuk@eleanorsoft.com>
     */
    public function getLoginUrl()
    {
        return self::getServiceInstance()->getLoginUrl();
    }

    /**
     * Get oauth token.
     *
     * @param $code
     * @return mixed
     * @author Eugene Polischuk <eugene.polischuk@eleanorsoft.com>
     */
    public function getOAuthToken($code)
    {
        return self::getServiceInstance()->getOAuthToken($code);
    }

    /**
     * Get photos from Instagram.
     *
     * @param int|null $count
     * @return array
     * @author Eugene Polischuk <eugene.polischuk@eleanorsoft.com>
     */
    public function getPhotos($count = null)
    {
        $this->reloadAccessToken();

        return $this->convertSourceImages(
            self::getServiceInstance()->getUserMedia('self', $count)->data
        );
    }

    /**
     * Get access token from config table.
     *
     * @author Eugene Polischuk <eugene.polischuk@eleanorsoft.com>
     */
    private function reloadAccessToken()
    {
        self::getServiceInstance()->setAccessToken(
            $this->moduleConfig->getTokenValue()
        );
    }

    /**
     * Convert Instagram images to module photos.
     *
     * @param $sourceImages
     * @return array
     * @author Eugene Polischuk <eugene.polischuk@eleanorsoft.com>
     */
    private function convertSourceImages($sourceImages)
    {
        $adapterImages = [];

        foreach ($sourceImages as $sourceImage) {
            $imageAdapter = new ImageAdapter();

            $imageAdapter->setResource($sourceImage);

            $adapterImages[] = $imageAdapter;
        }

        return $adapterImages;
    }
}
