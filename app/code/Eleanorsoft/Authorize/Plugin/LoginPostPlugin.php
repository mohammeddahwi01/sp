<?php

namespace Eleanorsoft\Authorize\Plugin;

use Magento\Framework\App\Action\Action;

class LoginPostPlugin extends PostPlugin
{
    private $isAlreadySigned = false;

    public function beforeExecute(Action $subject, ...$args) {
        if (!$this->isModuleEnabled()) {
            return;
        }

        if ($this->customerSession->isLoggedIn()) {
            $this->isAlreadySigned = true;
        }
    }

    public function afterExecute(Action $subject, $result)
    {
        if (!$this->isModuleEnabled()) {
            return $result;
        }

        if ($this->isAlreadySigned) {
            $this->prepareResponse();
            $this->response->setBody(json_encode([
                'success' => true,
                'messages' => [__('Already signed')]
            ]));

            return $this->response;
        }

        if ($this->customerSession->isLoggedIn()) {
            $this->prepareResponse();
            $this->response->setBody(json_encode([
                'success' => true,
                'messages' => [__('Signed successfully')]
            ]));

            return $this->response;
        }

        return parent::afterExecute($subject, $result);
    }
}
