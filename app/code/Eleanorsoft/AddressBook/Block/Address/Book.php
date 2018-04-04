<?php

namespace Eleanorsoft\AddressBook\Block\Address;

use Magento\Customer\Block\Address\Book as BaseBook;
use Magento\Customer\Api\AddressRepositoryInterface;
use Magento\Customer\Api\CustomerRepositoryInterface;
use Magento\Customer\Model\Address\Mapper;

/**
 * Class Book
 * Preference block class
 *
 * @author Eugene Polischuk <eugene.polischuk@eleanorsoft.com>
 * @copyright Copyright (c) 2017 Eleanorsoft (https://www.eleanorsoft.com/)
 */
class Book extends BaseBook
{

    private $helper;
    
    public function __construct(\Magento\Framework\View\Element\Template\Context $context,
        CustomerRepositoryInterface $customerRepository,
        AddressRepositoryInterface $addressRepository,
        \Magento\Customer\Helper\Session\CurrentCustomer $currentCustomer,
        \Magento\Customer\Model\Address\Config $addressConfig,
        Mapper $addressMapper,
        \Eleanorsoft\AddressBook\Helper\Data $helper,
        array $data
    ) {
        $this->helper = $helper;
        parent::__construct($context, $customerRepository, $addressRepository, $currentCustomer, $addressConfig, $addressMapper, $data);
    }

    /**
     * Set page title
     *
     * @return $this
     * @author Eugene Polischuk <eugene.polischuk@eleanorsoft.com>
     */
    protected function _prepareLayout()
    {
        if ($this->helper->isEnabled()) {
            $this->pageConfig->getTitle()->set(__('Personal Data'));
            return $this;
        }
        return parent::_prepareLayout();
    }
}
