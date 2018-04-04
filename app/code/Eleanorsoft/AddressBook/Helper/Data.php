<?php

namespace Eleanorsoft\AddressBook\Helper;

/**
 * Data.php
 * Useful module functions
 *
 * @package Eleanorsoft_AddressBook
 * @author Konstantin Esin <hello@eleanorsoft.com>
 * @copyright Copyright (c) 2018 Eleanorsoft (https://www.eleanorsoft.com/)
 */


class Data extends \Magento\Framework\App\Helper\AbstractHelper
{
    /**
     * Is module enabled in config?
     *
     * @return boolean
     * @author Konstantin Esin <hello@eleanorsoft.com>
     */
    public function isEnabled()
    {
        return $this->scopeConfig->getValue('eleanorsoft_onepage_address_book/general/enabled', \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
    }
}