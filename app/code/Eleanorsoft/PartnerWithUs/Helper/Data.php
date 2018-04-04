<?php

namespace Eleanorsoft\PartnerWithUs\Helper;

use Magento\Framework\App\Helper\AbstractHelper;

/**
 * Partner With Us base helper
 */
class Data extends AbstractHelper
{
    const XML_PATH_ENABLED = 'eleanorsoft_partner_with_us/general/enabled';
    const XML_PATH_EMAIL_TEMPLATE = 'eleanorsoft_partner_with_us/email/email_template';
    const XML_PATH_EMAIL_RECIPIENT = 'eleanorsoft_partner_with_us/email/recipient_email';
    const XML_PATH_EMAIL_SENDER = 'eleanorsoft_partner_with_us/email/sender_email_identity';
}
