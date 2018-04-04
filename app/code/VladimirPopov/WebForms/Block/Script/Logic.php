<?php


namespace VladimirPopov\WebForms\Block\Script;

class Logic extends \Magento\Framework\View\Element\Template
{
    protected $_form;

    protected $_template = 'VladimirPopov_WebForms::webforms/scripts/logic.phtml';

    public function setForm(\VladimirPopov\WebForms\Model\Form $form){
        $this->_form = $form;
        return $this;
    }

    public function getForm(){
        return $this->_form;
    }
}