<?php

namespace Eleanorsoft\Instagram\Instagram\Api\Adapter;

/**
 * Interface AdapterInterface
 * Instagram adapter interface.
 *
 * @author Eugene Polischuk <eugene.polischuk@eleanorsoft.com>
 * @copyright Copyright (c) 2017 Eleanorsoft (https://www.eleanorsoft.com/)
 */
interface AdapterInterface
{
    /**
     * Generates the OAuth login URL.
     *
     * @return string
     * @author Eugene Polischuk <eugene.polischuk@eleanorsoft.com>
     */
    public function getLoginUrl();

    /**
     * Get OAuth token object.
     *
     * @param $code
     * @return mixed
     * @author Eugene Polischuk <eugene.polischuk@eleanorsoft.com>
     */
    public function getOAuthToken($code);

    /**
     * Get photos from Instagram.
     *
     * @param $count
     * @return array
     * @author Eugene Polischuk <eugene.polischuk@eleanorsoft.com>
     */
    public function getPhotos($count = null);
}
