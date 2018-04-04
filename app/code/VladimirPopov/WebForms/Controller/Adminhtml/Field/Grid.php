<?php


namespace VladimirPopov\WebForms\Controller\Adminhtml\Field;

class Grid extends \VladimirPopov\WebForms\Controller\Adminhtml\Index
{
    public function execute()
    {
        $this->_initForm();
        $resultLayout = $this->resultLayoutFactory->create();
        return $resultLayout;
    }
}
