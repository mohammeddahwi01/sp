<?php

namespace Eleanorsoft\Authorize\Helper;

use \Eleanorsoft\Lib\Helper\Data as LibHelper;

/**
 * Class Data
 * Module general config.
 *
 * @package Eleanorsoft\Authorize\Model
 * @author Eugene Polischuk <eugene.polischuk@eleanorsoft.com>
 * @copyright Copyright (c) 2017 Eleanorsoft (https://www.eleanorsoft.com/)
 */
class Data extends LibHelper
{
    /**
     * Get module name.
     *
     * @return string
     * @author Eugene Polischuk <eugene.polischuk@eleanorsoft.com>
     */
    public function getModuleName()
    {
        return 'eleanorsoft_authorize';
    }
}
