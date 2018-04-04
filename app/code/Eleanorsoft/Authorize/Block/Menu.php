<?php

namespace Eleanorsoft\Authorize\Block;

use \Magento\Customer\Block\Form\Login;
use \Magento\Customer\Model\Session;
use \Magento\Framework\View\Element\Template;

/**
 * Class Menu
 * Top menu block with account links
 *
 * @package Eleanorsoft_Authorize
 * @author Konstantin Esin <hello@eleanorsoft.com>
 * @copyright Copyright (c) 2018 Eleanorsoft (https://www.eleanorsoft.com/)
 */
class Menu extends Template
{
    /**
     * Customer's session
     *
     * @var Session
     */
    protected $session;

    /**
     * Menu constructor.
     * @param Template\Context $context
     * @param Session $session
     * @param array $data
     * @author Konstantin Esin <hello@eleanorsoft.com>
     */
    public function __construct(
        Template\Context $context,
        Session $session,
        array $data = []
    ) {
        $this->session = $session;
        parent::__construct($context, $data);
    }

    /**
     * True - customer is logged in
     *
     * @return bool
     * @author Konstantin Esin <hello@eleanorsoft.com>
     */
    public function isCustomerLoggedIn()
    {
        return $this->session->isLoggedIn();
    }
}
