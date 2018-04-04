<?php


namespace VladimirPopov\WebForms\Controller\Adminhtml\Result;

class Grid extends \VladimirPopov\WebForms\Controller\Adminhtml\Index
{
    public function execute()
    {
        $this->_initForm('webform_id');
        $resultLayout = $this->resultLayoutFactory->create();
        return $resultLayout;
    }
}
