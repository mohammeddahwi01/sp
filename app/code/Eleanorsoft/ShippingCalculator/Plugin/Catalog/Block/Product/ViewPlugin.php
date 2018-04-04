<?php

namespace Eleanorsoft\ShippingCalculator\Plugin\Catalog\Block\Product;

use \Magento\Catalog\Model\Product;
use \Magento\Catalog\Block\Product\View;
use \Eleanorsoft\ShippingCalculator\Model\EstimateDeliveryDate;

class ViewPlugin
{
    protected $estimateDeliveryDate;

    public function __construct(
        EstimateDeliveryDate $estimateDeliveryDate
    ) {
        $this->estimateDeliveryDate = $estimateDeliveryDate;
    }

    public function afterGetProduct(View $subject, Product $result)
    {
        return $result->setData('estimateDeliveryDate',
            $this->estimateDeliveryDate->getEstimateDeliveryDateByProductId($result->getId())
        );
    }
}
