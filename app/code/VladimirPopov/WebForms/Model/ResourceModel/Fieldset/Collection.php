<?php


namespace VladimirPopov\WebForms\Model\ResourceModel\Fieldset;

/**
 * Fieldset collection
 *
 */
class Collection extends \VladimirPopov\WebForms\Model\ResourceModel\AbstractCollection
{
    /**
     * Constructor
     * Configures collection
     *
     * @return void
     */
    protected function _construct()
    {
        parent::_construct();
        $this->_init('VladimirPopov\WebForms\Model\Fieldset', 'VladimirPopov\WebForms\Model\ResourceModel\Fieldset');
    }

}
