<?php

namespace Eleanorsoft\Authorize\Block;

use \Magento\Customer\Block\Form\Login;
use \Magento\Framework\View\Element\Template;

class Authorize extends Template
{
    protected $loginBlock;

    public function __construct(
        Template\Context $context,
        Login $loginBlock,
        array $data = []
    ) {
        $this->loginBlock = $loginBlock;
        parent::__construct($context, $data);
    }

    public function getLoginActionUrl()
    {
        return $this->getUrl('eleanorsoft_authorize/customer/login');
    }
}
