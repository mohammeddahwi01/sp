<?php

namespace Eleanorsoft\Lib\Plugin;

use \Magento\Framework\UrlInterface;
use \Magento\Framework\App\Action\Action;
use \Magento\Framework\Message\ManagerInterface;
use \Magento\Framework\Message\MessageInterface;
use \Magento\Customer\Model\Session as CustomerSession;
use \Magento\Framework\App\Request\Http as HttpRequest;
use \Magento\Framework\App\Response\Http as HttpResponse;

/**
 * Class AjaxFormPostPlugin
 * Ajax plugin class for controllers.
 *
 * @package Eleanorsoft\Lib\Plugin
 * @author Eugene Polischuk <eugene.polischuk@eleanorsoft.com>
 * @copyright Copyright (c) 2017 Eleanorsoft (https://www.eleanorsoft.com/)
 */
class AjaxFormPostPlugin
{
    /**
     * @var UrlInterface
     */
    protected $url;

    /**
     * @var HttpRequest
     */
    protected $request;

    /**
     * @var HttpResponse
     */
    protected $response;

    /**
     * @var ManagerInterface
     */
    protected $messageManager;

    /**
     * @var CustomerSession
     */
    protected $customerSession;

    /**
     * AjaxFormPostPlugin constructor.
     *
     * @param UrlInterface $url
     * @param HttpRequest $request
     * @param HttpResponse $response
     * @param ManagerInterface $messageManager
     * @param CustomerSession $customerSession
     * @author Eugene Polischuk <eugene.polischuk@eleanorsoft.com>
     */
    public function __construct(
        UrlInterface $url,
        HttpRequest $request,
        HttpResponse $response,
        ManagerInterface $messageManager,
        CustomerSession $customerSession
    ) {
        $this->url = $url;
        $this->request = $request;
        $this->response = $response;
        $this->messageManager = $messageManager;
        $this->customerSession = $customerSession;
    }

    /**
     * Return json response.
     *
     * @param Action $subject
     * @param $result
     * @return HttpResponse
     * @author Eugene Polischuk <eugene.polischuk@eleanorsoft.com>
     */
    public function afterExecute(Action $subject, $result)
    {
        if ($this->request->isAjax()) {
            $this->prepareResponse();
            $this->response->setBody(json_encode($this->getMessageData()));

            return $this->response;
        }

        return $result;
    }

    /**
     * Clear http header from redirect.
     *
     * @author Eugene Polischuk <eugene.polischuk@eleanorsoft.com>
     */
    protected function prepareResponse()
    {
        $this->response->clearHeader('Location');
        $this->response->setHttpResponseCode(200);
    }

    /**
     * Get message data from session messages.
     *
     * @return array
     * @author Eugene Polischuk <eugene.polischuk@eleanorsoft.com>
     */
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
