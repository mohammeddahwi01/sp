<?php

namespace Eleanorsoft\AddressBook\Block\Address;

use \Exception;
use \Magento\Customer\Block\Address\Edit;

/**
 * Class Address
 *
 * @author Eugene Polischuk <eugene.polischuk@eleanorsoft.com>
 * @copyright Copyright (c) 2017 Eleanorsoft (https://www.eleanorsoft.com/)
 */
class Address extends Edit
{
    const TYPE_BILLING = 'billing';

    const TYPE_SHIPPING = 'shipping';

    /**
     * @var string
     */
    private $addressType;

    /**
     * @var string
     */
    private $formHeadingText;

    /**
     * @var string
     */
    protected $_template = 'address/address.phtml';

    /**
     * Get html form id.
     *
     * @return string
     * @author Eugene Polischuk <eugene.polischuk@eleanorsoft.com>
     */
    public function getFormId()
    {
        return $this->getAddressPrefix() . 'address-ajax-form';
    }

    /**
     * Get form html.
     *
     * @return string
     * @author Eugene Polischuk <eugene.polischuk@eleanorsoft.com>
     */
    public function getAddressFormHtml()
    {
        return $this->fetchView(
            $this->getTemplateFile('Eleanorsoft_AddressBook::address/address.phtml')
        );
    }

    /**
     * Get country select html.
     *
     * @param null $defValue
     * @param string $name
     * @param string $id
     * @param string $title
     * @return string
     * @author Eugene Polischuk <eugene.polischuk@eleanorsoft.com>
     */
    public function getCountryHtmlSelect($defValue = null, $name = 'country_id', $id = 'country', $title = 'Country')
    {
        return parent::getCountryHtmlSelect($defValue, $name, $this->getAddressPrefix() . $id, $title);
    }

    /**
     * Get address prefix.
     *
     * @return string
     * @author Eugene Polischuk <eugene.polischuk@eleanorsoft.com>
     */
    public function getAddressPrefix()
    {
        return $this->getAddressType() . '-';
    }

    /**
     * Get address type.
     *
     * @return mixed
     * @author Eugene Polischuk <eugene.polischuk@eleanorsoft.com>
     */
    public function getAddressType()
    {
        return $this->addressType;
    }

    /**
     * Set address type.
     *
     * @param $addressType
     * @return $this
     * @throws Exception
     * @author Eugene Polischuk <eugene.polischuk@eleanorsoft.com>
     */
    public function setAddressType($addressType)
    {
        if (!in_array($addressType, [self::TYPE_BILLING, self::TYPE_SHIPPING])) {
            throw new Exception('Address type is not allowed.');
        }

        $this->addressType = $addressType;

        return $this;
    }

    /**
     * Get form heading text.
     *
     * @return mixed
     * @author Eugene Polischuk <eugene.polischuk@eleanorsoft.com>
     */
    public function getFormHeadingText()
    {
        return $this->formHeadingText;
    }

    /**
     * Set form heading text.
     *
     * @param $formHeadingText
     * @return $this
     * @author Eugene Polischuk <eugene.polischuk@eleanorsoft.com>
     */
    public function setFormHeadingText($formHeadingText)
    {
        $this->formHeadingText = __($formHeadingText);

        return $this;
    }

    public function getNameBlockHtml()
    {
        $nameBlock = $this->getLayout()
            ->createBlock('Magento\Customer\Block\Widget\Name')
            ->setData('field_id_format', $this->getAddressPrefix() . '%s')
            ->setObject($this->getAddress());

        return $nameBlock->toHtml();
    }

    public function getAddressesData()
    {
        $addressData = [];

        foreach ($this->getCustomer()->getAddresses() as $address) {
            $addressData[] = [
                'id' => $address->getId(),
                'firstname' => $address->getFirstname(),
                'lastname' => $address->getLastname(),
                'company' => $address->getCompany(),
                'telephone' => $address->getTelephone(),
                'street' => $address->getStreet(),
                'city' => $address->getCity(),
                'postcode' => $address->getPostcode(),
                'regionId' => $address->getRegion()->getRegionId(),
                'countryId' => $address->getCountryId()
            ];
        };

        return $addressData;
    }

    public function getAddressesDataJson()
    {
        return json_encode($this->getAddressesData());
    }
}
