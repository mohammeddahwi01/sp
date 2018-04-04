<?php

namespace VladimirPopov\WebForms\Model\Mail;

use VladimirPopov\WebForms\Model\Api;

class TransportBuilder extends \Magento\Framework\Mail\Template\TransportBuilder
{
    /**
     * @param Api\AttachmentInterface $attachment
     */
    public function addAttachment(Api\AttachmentInterface $attachment)
    {
        $this->message->createAttachment(
            $attachment->getContent(),
            $attachment->getMimeType(),
            $attachment->getDisposition(),
            $attachment->getEncoding(),
            $this->encodedFileName($attachment->getFilename())
        );
    }

    protected function encodedFileName($subject)
    {
        return sprintf('=?utf-8?B?%s?=', base64_encode($subject));
    }

    public function getMessage(){
        return $this->message;
    }

    public function createAttachment($attachment, $type, $disposition, $encoding, $name){
        $this->message->createAttachment($attachment, $type, $disposition, $encoding, $name);
        return $this;
    }
}