<?php

namespace Eleanorsoft\Authorize\Plugin;

use Magento\Framework\UrlInterface;
use Magento\Framework\App\Action\Action;
use Magento\Framework\Message\ManagerInterface;
use Magento\Framework\Message\MessageInterface;
use Magento\Customer\Model\Session as CustomerSession;
use Eleanorsoft\Authorize\Helper\Data as ModuleHelper;
use Magento\Framework\App\Request\Http as HttpRequest;
use Magento\Framework\App\Response\Http as HttpResponse;

class PostPlugin
{
    protected $url;
    protected $request;
    protected $response;
    protected $moduleHelper;
    protected $messageManager;
    protected $customerSession;

    public function __construct(
        UrlInterface $url,
        HttpRequest $request,
        HttpResponse $response,
        ModuleHelper $moduleHelper,
        ManagerInterface $messageManager,
        CustomerSession $customerSession
    ) {
        $this->url = $url;
        $this->request = $request;
        $this->response = $response;
        $this->moduleHelper = $moduleHelper;
        $this->messageManager = $messageManager;
        $this->customerSession = $customerSession;
    }

    public function isModuleEnabled()
    {
        return $this->moduleHelper->isModuleEnabled();
    }

    public function afterExecute(Action $subject, $result)
    {
        if (!$this->isModuleEnabled()) {
            return $result;
        }

        if ($this->request->isAjax()) {
            $this->prepareResponse();
            $this->response->setBody(json_encode($this->getMessageData()));

            return $this->response;
        }

        return $result;
    }

    protected function prepareResponse()
    {
        $this->response->clearHeader('Location');
        $this->response->setHttpResponseCode(200);
    }

    protected function getMessageData()
    {
        $messageData = ['success' => null, 'messages' => []];
        $messages = $this->messageManager->getMessages();
        $errorMessages = $messages->getErrors();
        $successMessages = $messages->getItemsByType(MessageInterface::TYPE_SUCCESS);

        $messages->clear();

        if (count($errorMessages)) {
            $messageData['success'] = false;

            foreach ($errorMessages as $message) {
                $messageData['messages'][] = $message->getText();
            }
        } elseif (count($successMessages)) {
            $messageData['success'] = true;

            foreach ($successMessages as $message) {
                $messageData['messages'][] = $message->getText();
            }
        }

        return $messageData;
    }
}
