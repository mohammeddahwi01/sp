<?php


namespace VladimirPopov\WebForms\Block\Adminhtml\Logic\Renderer;

class Value extends \Magento\Backend\Block\Widget\Grid\Column\Renderer\AbstractRenderer
{

    public function render(\Magento\Framework\DataObject $row)
    {
        $value =  $row->getData($this->getColumn()->getIndex());
        return implode('<br>',$value);
    }

}