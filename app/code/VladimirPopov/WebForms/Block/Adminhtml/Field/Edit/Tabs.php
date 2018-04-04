<?php


namespace VladimirPopov\WebForms\Block\Adminhtml\Field\Edit;

class Tabs extends \Magento\Backend\Block\Widget\Tabs
{
    /**
     * @return void
     */
    protected function _construct()
    {
        parent::_construct();
        $this->setId('field_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle(__('Field Information'));
    }
}