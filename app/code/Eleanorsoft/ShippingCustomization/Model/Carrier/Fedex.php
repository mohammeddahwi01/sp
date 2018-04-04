<?php

namespace Eleanorsoft\ShippingCustomization\Model\Carrier;

use Magento\Framework\Module\Dir;
use Magento\Framework\Xml\Security;
use Magento\Quote\Model\Quote\Address\RateRequest;
use Magento\Shipping\Model\Tracking\Result as TrackingResult;

/**
 * Class Flatrate
 * todo: What is its purpose? What does it do?
 *
 * @package Eleanorsoft\ShippingMethod\Model\Carrier
 * @author Konstantin Esin <hello@eleanorsoft.com>
 * @copyright Copyright (c) 2018 Eleanorsoft (https://www.eleanorsoft.com/)
 */
class Fedex extends \Magento\Fedex\Model\Carrier
{
    /**
     * todo: What is its purpose?
     *
     * @var \Eleanorsoft\ShippingCustomization\Helper\Data
     */
    protected $shippingCustomizationHelper;

    public function __construct(
        Security $xmlSecurity,
        Dir\Reader $configReader,
        \Psr\Log\LoggerInterface $logger,
        \Magento\Directory\Helper\Data $directoryData,
        TrackingResult\ErrorFactory $trackErrorFactory,
        TrackingResult\StatusFactory $trackStatusFactory,
        \Magento\Directory\Model\RegionFactory $regionFactory,
        \Magento\Directory\Model\CountryFactory $countryFactory,
        \Magento\Shipping\Model\Rate\ResultFactory $rateFactory,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Directory\Model\CurrencyFactory $currencyFactory,
        \Magento\Shipping\Model\Tracking\ResultFactory $trackFactory,
        \Magento\Shipping\Model\Simplexml\ElementFactory $xmlElFactory,
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
        \Magento\CatalogInventory\Api\StockRegistryInterface $stockRegistry,
        \Eleanorsoft\ShippingCustomization\Helper\Data $shippingCustomizationHelper,
        \Magento\Quote\Model\Quote\Address\RateResult\ErrorFactory $rateErrorFactory,
        \Magento\Quote\Model\Quote\Address\RateResult\MethodFactory $rateMethodFactory,
        \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory $productCollectionFactory,
        array $data = []
    ) {
        $this->shippingCustomizationHelper = $shippingCustomizationHelper;

        parent::__construct(
            $scopeConfig,
            $rateErrorFactory,
            $logger,
            $xmlSecurity,
            $xmlElFactory,
            $rateFactory,
            $rateMethodFactory,
            $trackFactory,
            $trackErrorFactory,
            $trackStatusFactory,
            $regionFactory,
            $countryFactory,
            $currencyFactory,
            $directoryData,
            $stockRegistry,
            $storeManager,
            $configReader,
            $productCollectionFactory,
            $data
        );
    }

    public function collectRates(RateRequest $request)
    {
        if (!$this->canCollectRates()) {
            return $this->getErrorMessage();
        }

        $methodAllowed = true;

        foreach ($request->getAllItems() as $item) {
            if ($this->shippingCustomizationHelper->isFreightProduct($item)) {
                $methodAllowed = false;
            }
        }

        if (!$methodAllowed) {
            return $this->_rateFactory->create();
        }

        return parent::collectRates($request);
    }
}
