<?php

namespace Eleanorsoft\TradeClients\Helper;

use Eleanorsoft\CustomForm\Helper\Data as BaseData;
/**
 * Class Data
 *
 * @package Eleanorsoft\TradeClients\Helper
 * @author Pisarenko Denis <denis.pisarenko@eleanorsoft.com>
 * @copyright Copyright (c) 2018 Eleanorsoft (https://www.eleanorsoft.com/)
 */

class Data extends BaseData
{
    protected $enabled = 'trade_clients/general/enabled';
    protected $template = 'trade_clients/email/email_template';
    protected $sender = 'trade_clients/email/sender_email_identity';
    protected $recipient = 'trade_clients/email/recipient_email';
}