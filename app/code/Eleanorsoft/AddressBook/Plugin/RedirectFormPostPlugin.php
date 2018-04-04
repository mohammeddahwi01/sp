<?php

namespace Eleanorsoft\AddressBook\Plugin;

use Magento\Framework\App\Action\Context;

/**
 * Class RedirectFormPostPlugin
 * todo: What is its purpose? What does it do?
 *
 * @package Eleanorsoft_
 * @author Pisarenko Denis <denis.pisarenko@eleanorsoft.com>
 * @copyright Copyright (c) 2018 Eleanorsoft (https://www.eleanorsoft.com/)
 */

class RedirectFormPostPlugin
{
    /**
     * @var \Magento\Framework\Controller\Result\RedirectFactory
     */
    protected $resultRedirectFactory;

    public function __construct(Context $context)
    {
        $this->resultRedirectFactory = $context->getResultRedirectFactory();
    }


    public function afterExecute()
    {
        $redirect = $this->resultRedirectFactory->create();

        return $redirect->setPath('addressbook/address/index');
    }
}