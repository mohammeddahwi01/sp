<?php


namespace VladimirPopov\WebForms\Model\ResourceModel\File;

/**
 * Result collection
 *
 */
class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
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
        $this->_init('VladimirPopov\WebForms\Model\File', 'VladimirPopov\WebForms\Model\ResourceModel\File');
    }
}