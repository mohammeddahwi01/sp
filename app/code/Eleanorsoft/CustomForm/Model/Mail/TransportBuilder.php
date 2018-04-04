<?php

namespace Eleanorsoft\CustomForm\Model\Mail;

use Eleanorsoft\CustomForm\Helper\CustomFormHelperInterface;
use Magento\Framework\Mail\Template\TransportBuilder as Transport;


/**
 * Class TransportBuilder
 * Override parent class
 *
 * @package Eleanorsoft_CustomFrom
 * @author Pisarenko Denis <denis.pisarenko@eleanorsoft.com>
 * @copyright Copyright (c) 2018 Eleanorsoft (https://www.eleanorsoft.com/)
 */

class TransportBuilder extends Transport
{


    /**
     * add files
     *
     * @param $attachments
     * @return $this
     * @author Pisarenko Denis <denis.pisarenko@eleanorsoft.com>
     * @copyright Copyright (c) 2018 Eleanorsoft (https://www.eleanorsoft.com/)
     */
    public function addAttachment($attachments)
    {
       if ($attachments){
           for ($i = 0; $i < count($attachments); $i++){
               $this->message->createAttachment(
                   $attachments[$i][CustomFormHelperInterface::ATTACHMENT_FILE_CONTENT],
                   'application/octet-stream',
                   \Zend_Mime::DISPOSITION_ATTACHMENT,
                   \Zend_Mime::ENCODING_BASE64,
                   $attachments[$i][CustomFormHelperInterface::ATTACHMENT_FILE_NAME]
               );
           }
       }
       return $this;
    }
}