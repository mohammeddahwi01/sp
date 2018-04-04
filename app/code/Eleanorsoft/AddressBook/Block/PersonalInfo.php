<?php

namespace Eleanorsoft\AddressBook\Block;

use \Magento\Framework\View\Element\Template;
use \Magento\Customer\Api\Data\CustomerInterface;
use \Magento\Customer\Helper\Session\CurrentCustomer;
use \Magento\Framework\View\Element\Template\Context;
use \Magento\Customer\Api\CustomerRepositoryInterface;
use \Magento\Framework\Exception\NoSuchEntityException;

/**
 * Class PersonalInfo
 *
 * @author Eugene Polischuk <eugene.polischuk@eleanorsoft.com>
 * @copyright Copyright (c) 2017 Eleanorsoft (https://www.eleanorsoft.com/)
 */
class PersonalInfo extends Template
{
    /**
     * @var CurrentCustomer
     */
    protected $currentCustomer;

    /**
     * @var CustomerRepositoryInterface
     */
    protected $customerRepository;

    /**
     * PersonalInfo constructor.
     *
     * @param Context $context
     * @param CurrentCustomer $currentCustomer
     * @param CustomerRepositoryInterface $customerRepository
     * @param array $data
     * @author Eugene Polischuk <eugene.polischuk@eleanorsoft.com>
     */
    public function __construct(
        Context $context,
        CurrentCustomer $currentCustomer,
        CustomerRepositoryInterface $customerRepository,
        array $data = []
    ) {
        $this->currentCustomer = $currentCustomer;
        $this->customerRepository = $customerRepository;

        parent::__construct($context, $data);
    }

    /**
     * @return CustomerInterface|null
     */
    public function getCustomer()
    {
        $customer = $this->getData('customer');

        if ($customer === null) {
            try {
                $customer = $this->customerRepository->getById(
                    $this->currentCustomer->getCustomerId()
                );
            } catch (NoSuchEntityException $e) {
                return null;
            }

            $this->setData('customer', $customer);
        }

        return $customer;
    }
}
