<?php

namespace Eleanorsoft\Contact\Helper;

use \Eleanorsoft\Lib\Helper\Data as LibHelper;

/**
 * Class Data
 * Module general config.
 *
 * @package Eleanorsoft\Contact\Model
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
        return 'eleanorsoft_contact';
    }

    /**
     * This module has a specific path so we have to override
     * this function from Eleanorsoft_Lib module.
     *
     * @return boolean
     * @author Konstantin Esin <hello@eleanorsoft.com>
     */
    public function isModuleEnabled()
    {
        return $this->scopeConfig->getValue('contact/ajax_contacts/enabled', \Magento\Store\Model\ScopeInterface::SCOPE_STORE);;
    }
}
