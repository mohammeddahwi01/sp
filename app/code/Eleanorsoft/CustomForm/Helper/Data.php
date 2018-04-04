<?php

namespace Eleanorsoft\CustomForm\Helper;

use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\DataObject;
use Magento\Store\Model\ScopeInterface;


/**
 * Class Data
 *
 * @package Eleanorsoft_CustomForm
 * @author Pisarenko Denis <denis.pisarenko@eleanorsoft.com>
 * @copyright Copyright (c) 2018 Eleanorsoft (https://www.eleanorsoft.com/)
 */

 abstract class Data extends AbstractHelper implements CustomFormHelperInterface
{
    protected $enabled;
    protected $template;
    protected $sender;
    protected $recipient;

    private $storeScope = ScopeInterface::SCOPE_STORE;

     /**
      * Check if contacts module is enabled
      *
      * @return string
      * @throws \Exception
      * @author Pisarenko Denis <denis.pisarenko@eleanorsoft.com>
      * @copyright Copyright (c) 2018 Eleanorsoft (https://www.eleanorsoft.com/)
      */
     public function isEnabled()
     {
         if (!$this->enabled){
             throw new \Exception('can\'t read setting option \'enabled\'');
         }
         return $this->scopeConfig->getValue($this->enabled, $this->storeScope);
     }

     /**
      * Return email template identifier
      *
      * @return string
      * @throws \Exception
      * @author Pisarenko Denis <denis.pisarenko@eleanorsoft.com>
      * @copyright Copyright (c) 2018 Eleanorsoft (https://www.eleanorsoft.com/)
      */
     public function emailTemplate()
     {
         if (!$this->template){
            throw new \Exception('undefined template');
         }
         return $this->scopeConfig->getValue($this->template, $this->storeScope);
     }

     /**
      * Return email sender address
      *
      * @return string
      * @throws \Exception
      * @author Pisarenko Denis <denis.pisarenko@eleanorsoft.com>
      * @copyright Copyright (c) 2018 Eleanorsoft (https://www.eleanorsoft.com/)
      */
     public function emailSender()
     {
         if (!$this->sender){
             throw new \Exception('undefined sender');
         }
         return $this->scopeConfig->getValue($this->sender, $this->storeScope);
     }

     /**
      * Return email recipient address
      *
      * @return string
      * @throws \Exception
      * @author Pisarenko Denis <denis.pisarenko@eleanorsoft.com>
      * @copyright Copyright (c) 2018 Eleanorsoft (https://www.eleanorsoft.com/)
      */
     public function emailRecipient()
     {
         if (!$this->recipient){
             throw new \Exception('undefined recipient');
         }
         $currentRecipient = $this->scopeConfig->getValue($this->recipient, $this->storeScope);

         if ($currentRecipient){
             return $this->scopeConfig->getValue($this->recipient, $this->storeScope);
         }

         return $this->scopeConfig->getValue(self::DEFAULT_EMAIL_RECIPIENT, $this->storeScope);
     }

     /**
      * Set data email form to object
      *
      * @param $data
      * @return DataObject
      * @internal param $post
      * @author Pisarenko Denis <denis.pisarenko@eleanorsoft.com>
      * @copyright Copyright (c) 2018 Eleanorsoft (https://www.eleanorsoft.com/)
      */
     public function getEmailVariables($data)
     {
         $postObject = new DataObject();
         $postObject->setData($data);

         return $postObject;
     }

     /**
      * Add file to email
      * @return mixed
      * @throws \Exception
      * @author Pisarenko Denis <denis.pisarenko@eleanorsoft.com>
      * @copyright Copyright (c) 2018 Eleanorsoft (https://www.eleanorsoft.com/)
      */
     public function getEmailAttachments()
     {

         return array();
     }

     /**
      * Validating form data
      *
      * @param $post
      * @return mixed|void
      * @throws \Exception
      * @author Pisarenko Denis <denis.pisarenko@eleanorsoft.com>
      * @copyright Copyright (c) 2018 Eleanorsoft (https://www.eleanorsoft.com/)
      */
     public function validate($post)
     {
         $error = '';
         $values = ['email'];// add field for validation

         if ($values){
             foreach ($values as $value){
                 $error = $this->getPostFieldValuesError($post, $value);

                 if ($error) {
                     throw new \Exception($error, self::HANDLE_ERROR_STATUS_CODE);
                 }
             }
         }
     }

     /**
      * Checks the type of field to check
      *
      * @param $post
      * @param $value
      * @return string
      * @author Pisarenko Denis <denis.pisarenko@eleanorsoft.com>
      * @copyright Copyright (c) 2018 Eleanorsoft (https://www.eleanorsoft.com/)
      */
     protected function getPostFieldValuesError($post, $value)
     {
         $error = '';
         switch ($value){
             case self::EMAIL:
                 if (!$this->validateFieldValue($post[$value], 'EmailAddress')) {
                     $error = 'Email is not correct.';
                 }
                 break;
             default:
                 if (!$this->validateFieldValue($post[$value], 'NotEmpty')) {
                     $error = 'Name field is empty.';
                 }
         }
         return $error;
     }

     /**
      * Validating form data
      *
      * @param $value
      * @param $rule
      * @author Pisarenko Denis <denis.pisarenko@eleanorsoft.com>
      * @copyright Copyright (c) 2018 Eleanorsoft (https://www.eleanorsoft.com/)
      * @return boolean
      */
     private function validateFieldValue($value, $rule)
     {
         if(!\Zend_Validate::is(trim($value), $rule)) {
             return false;
         }
         return true;
     }
 }