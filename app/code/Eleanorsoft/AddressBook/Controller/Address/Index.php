<?php

namespace Eleanorsoft\AddressBook\Controller\Address;

/**
 * Class Index
 *
 * @author Eugene Polischuk <eugene.polischuk@eleanorsoft.com>
 * @copyright Copyright (c) 2017 Eleanorsoft (https://www.eleanorsoft.com/)
 */
class Index extends \Magento\Customer\Controller\Address
{
    private $helper;
    private $customerRepository;
    private $registry;

    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Magento\Customer\Model\Session $customerSession,
        \Magento\Framework\Data\Form\FormKey\Validator $formKeyValidator,
        \Magento\Customer\Model\Metadata\FormFactory $formFactory,
        \Magento\Customer\Api\AddressRepositoryInterface $addressRepository,
        \Magento\Customer\Api\Data\AddressInterfaceFactory $addressDataFactory,
        \Magento\Customer\Api\Data\RegionInterfaceFactory $regionDataFactory,
        \Magento\Framework\Reflection\DataObjectProcessor $dataProcessor,
        \Magento\Framework\Api\DataObjectHelper $dataObjectHelper,
        \Magento\Framework\Controller\Result\ForwardFactory $resultForwardFactory,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory,
        \Magento\Customer\Api\CustomerRepositoryInterface $customerRepository,
        \Magento\Framework\Registry $registry,
        \Eleanorsoft\AddressBook\Helper\Data $helper
    ){
        $this->helper = $helper;
        $this->customerRepository = $customerRepository;
        $this->registry = $registry;
        parent::__construct($context, $customerSession, $formKeyValidator, $formFactory, $addressRepository, $addressDataFactory, $regionDataFactory, $dataProcessor, $dataObjectHelper, $resultForwardFactory, $resultPageFactory);
    }

    /**
     * Remove redirect when customer has no addresses.
     *
     * @return \Magento\Framework\View\Result\Page
     * @author Eugene Polischuk <eugene.polischuk@eleanorsoft.com>
     */
    public function execute()
    {
        if (!$this->helper->isEnabled()) {
            print 'disabled';exit;
            return parent::execute();
        }

        if ($this->getRequest()->getParam('method')) {
            $this->registry->register('tokenbase_method', $this->getRequest()->getParam('method'));
        } else {
            $this->registry->register('tokenbase_method', 'authnetcim');
        }

        $resultPage = $this->resultPageFactory->create();
        $block = $resultPage->getLayout()->getBlock('address_book');

        if ($block) {
            $block->setRefererUrl($this->_redirect->getRefererUrl());
        }

        return $resultPage;
    }
}
