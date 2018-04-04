<?php


namespace VladimirPopov\WebForms\Controller\Adminhtml\Result;

use VladimirPopov\WebForms\Controller\Adminhtml\AbstractMassDelete;

class MassDelete extends AbstractMassDelete
{
    const ID_FIELD = 'results';

    const REDIRECT_URL = 'webforms/result/index';

    const MODEL = 'VladimirPopov\WebForms\Model\Result';

    public function execute()
    {
        $this->redirect_params = ['_current' => true];
        return parent::execute();
    }
}
