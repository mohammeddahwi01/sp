<?php

namespace Eleanorsoft\CustomForm\Helper;

use Magento\Framework\DataObject;

/**
 * Interface CustomFormHelperInterface
 * The merged interfaces to use dependency injection
 *
 * @package Eleanorsoft_CustomForm
 * @author Pisarenko Denis <denis.pisarenko@eleanorsoft.com>
 * @copyright Copyright (c) 2018 Eleanorsoft (https://www.eleanorsoft.com/)
 */


interface CustomFormHelperInterface extends ValidateFormInterface
{

    const EMAIL = 'email';

    const ATTACHMENT_FILE_NAME = 'name';
    const ATTACHMENT_FILE_CONTENT = 'content';

    /**
     * Recipient email default config path
     */
    const DEFAULT_EMAIL_RECIPIENT = 'el_custom_form/email/recipient_email';


    /**
     * Check if contacts module is enabled
     *
     * @return string
     * @author Pisarenko Denis <denis.pisarenko@eleanorsoft.com>
     * @copyright Copyright (c) 2018 Eleanorsoft (https://www.eleanorsoft.com/)
     */
    public function isEnabled();

    /**
     * Return email template identifier
     *
     * @return string
     * @author Pisarenko Denis <denis.pisarenko@eleanorsoft.com>
     * @copyright Copyright (c) 2018 Eleanorsoft (https://www.eleanorsoft.com/)
     */
    public function emailTemplate();

    /**
     * Return email sender address
     *
     * @return string
     * @author Pisarenko Denis <denis.pisarenko@eleanorsoft.com>
     * @copyright Copyright (c) 2018 Eleanorsoft (https://www.eleanorsoft.com/)
     */
    public function emailSender();

    /**
     *  Return email recipient address
     *
     * @return string
     * @author Pisarenko Denis <denis.pisarenko@eleanorsoft.com>
     * @copyright Copyright (c) 2018 Eleanorsoft (https://www.eleanorsoft.com/)
     */
    public function emailRecipient();

    /**
     * Set data email form to object
     *
     * @param $data
     * @return DataObject
     * @internal param $post
     * @author Pisarenko Denis <denis.pisarenko@eleanorsoft.com>
     * @copyright Copyright (c) 2018 Eleanorsoft (https://www.eleanorsoft.com/)
     */
    public function getEmailVariables($data);

    /**
     * Add file to email
     *
     * @return mixed
     * @author Pisarenko Denis <denis.pisarenko@eleanorsoft.com>
     * @copyright Copyright (c) 2018 Eleanorsoft (https://www.eleanorsoft.com/)
     */
    public function getEmailAttachments();

}