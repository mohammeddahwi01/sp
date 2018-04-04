<?php

namespace Eleanorsoft\AddressBook\Block;

use ParadoxLabs\TokenBase\Block\Customer\Form;

/**
 * Class CreditCardForm
 * todo: What is its purpose? What does it do?
 *
 * @package Eleanorsoft_
 * @author Pisarenko Denis <denis.pisarenko@eleanorsoft.com>
 * @copyright Copyright (c) 2018 Eleanorsoft (https://www.eleanorsoft.com/)
 */

class CreditCardForm extends Form
{

    public function getAction()
    {
        return $this->getUrl('customer/paymentinfo/save', ['_secure' => true]);
    }

}