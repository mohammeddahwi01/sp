<?php

namespace Eleanorsoft\CustomForm\Controller\Index;

use Eleanorsoft\CustomForm\Controller\Index as BaseIndex;
use Eleanorsoft\CustomForm\Helper\CustomFormHelperInterface;
use Eleanorsoft\CustomForm\Helper\ValidateFormInterface;
use Magento\Backend\App\Area\FrontNameResolver;
use Magento\Framework\App\Response\Http;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Exception\NotFoundException;
use Magento\Store\Model\Store;


/**
 * Class Post
 * Should be overridden in child modules. See example.
 *
 * @package Eleanorsoft_CustomForm
 * @author Pisarenko Denis <denis.pisarenko@eleanorsoft.com>
 * @copyright Copyright (c) 2018 Eleanorsoft (https://www.eleanorsoft.com/)
 */

abstract class Post extends BaseIndex

{

    /**
     * Execute action based on request and return result
     *
     * Note: Request will be added as operation argument in future
     *
     * @return \Magento\Framework\Controller\ResultInterface|ResponseInterface
     * @throws \Magento\Framework\Exception\NotFoundException
     */
    public function execute()
    {
        $data = $this->getRequest()->getPostValue();

        if (!$data) {
            return $this->_redirect('*/*/');
        }
        if ($this->getRequest()->isAjax()) {
            return $this->executeAjax($data);
        } else {
            throw new NotFoundException(__('Page not found.'));
        }
    }

    /**
     * Processes the ajax request
     *
     * @param $data
     * @author Pisarenko Denis <denis.pisarenko@eleanorsoft.com>
     * @copyright Copyright (c) 2018 Eleanorsoft (https://www.eleanorsoft.com/)
     */
    protected function executeAjax($data)
    {
        try {
            $this->customFormHelper->validate($data);

            $variables = $this->customFormHelper->getEmailVariables($data);
            $attachments = $this->customFormHelper->getEmailAttachments();
            $replyToEmail = $data[CustomFormHelperInterface::EMAIL];

            $this->sendMail($replyToEmail, $variables, $attachments);

            $code = Http::STATUS_CODE_200;
            $message = __(ValidateFormInterface::MESSAGE_SUCCESS);

        } catch (\Exception $e) {

            if ($e->getCode() == ValidateFormInterface::HANDLE_ERROR_STATUS_CODE) {
                $code = Http::STATUS_CODE_406;
                $message = __($e->getMessage());
            } else {
                $code = Http::STATUS_CODE_500;
                $message = __(ValidateFormInterface::MESSAGE_ERROR);
            }
        } finally {
            $this->inlineTranslation->resume();
        }

        $this->getResponse()->setStatusCode($code)->setContent($message);
    }

    /**
     * Sending email
     *
     * @param $replyTo
     * @param $variables
     * @param $attachments
     * @author Pisarenko Denis <denis.pisarenko@eleanorsoft.com>
     * @copyright Copyright (c) 2018 Eleanorsoft (https://www.eleanorsoft.com/)
     */
    protected function sendMail($replyTo, $variables, $attachments)
    {
        $this->inlineTranslation->suspend();

        $transport = $this->transportBuilder
            ->setTemplateIdentifier($this->customFormHelper->emailTemplate())
            ->setTemplateOptions(
                [
                    'area' => FrontNameResolver::AREA_CODE,
                    'store' => Store::DEFAULT_STORE_ID,
                ]
            )
            ->setTemplateVars(['data' => $variables])
            ->setFrom($this->customFormHelper->emailSender())
            ->addTo($this->customFormHelper->emailRecipient())
            ->setReplyTo($replyTo)
            ->addAttachment($attachments)
            ->getTransport();
        $transport->sendMessage();
    }
}
