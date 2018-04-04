<?php

namespace Eleanorsoft\ShippingCalculator\Model;

use \Magento\Quote\Model\Quote;
use \Magento\Checkout\Model\CartFactory;

/**
 * Class EstimateDeliveryDate
 * todo: What is its purpose? What does it do?
 *
 * @author Eugene Polischuk <eugene.polischuk@eleanorsoft.com>
 * @copyright Copyright (c) 2017 Eleanorsoft (https://www.eleanorsoft.com/)
 */
class EstimateDeliveryDate
{
    protected $cartFactory;

    public function __construct(
        CartFactory $cartFactory
    ) {
        $this->cartFactory = $cartFactory;
    }

    public function getEstimateDeliveryDateByProductId($productId)
    {
        return $this->validate($this->getQuote(), $productId) ? $this->getEstimateDeliveryDate() : null;
    }

    private function getQuote()
    {
        return $this->cartFactory->create()->getQuote();
    }

    private function isEstimateShippingCalculated(Quote $quote)
    {
        return $quote->getShippingAddress()->getShippingAmount() != 0;
    }

    private function validate(Quote $quote, $productId)
    {        
        return !$quote->getId() ? false : !in_array(false, $this->getValidateRules($quote, $productId));
    }

    private function getValidateRules(Quote $quote, $productId)
    {
        return [
            $this->isProductInQuote($quote, $productId),
            $this->isEstimateShippingCalculated($quote)
        ];
    }

    private function getEstimateDeliveryDate()
    {
        $date = new \DateTime();

        $date->modify('+2 days');

        return $date->format('d/m/Y');
    }

    private function isProductInQuote(Quote $quote, $productId)
    {
        $items = $quote->getAllVisibleItems();

        foreach ($items as $item) {
            if ($item->getProduct()->getId() == $productId) {
                return true;
            }
        }

        return false;
    }
}
