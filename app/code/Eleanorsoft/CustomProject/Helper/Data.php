<?php

namespace Eleanorsoft\CustomProject\Helper;

use Eleanorsoft\CustomForm\Helper\Data as BaseData;
/**
 * Class Data
 * todo: What is its purpose? What does it do?
 *
 * @package Eleanorsoft\CustomProject\Helper
 * @author Pisarenko Denis <denis.pisarenko@eleanorsoft.com>
 * @copyright Copyright (c) 2018 Eleanorsoft (https://www.eleanorsoft.com/)
 */

class Data extends BaseData
{
    protected $enabled = 'custom_project/general/enabled';
    protected $template = 'custom_project/email/email_template';
    protected $sender = 'custom_project/email/sender_email_identity';
    protected $recipient = 'custom_project/email/recipient_email';

}