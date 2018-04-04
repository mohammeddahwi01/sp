<?php

namespace Eleanorsoft\ShippingCustomization\Helper;

use Magento\Framework\App\Helper\AbstractHelper;
use Eleanorsoft\ShippingCustomization\Model\Config\Source\Options as ShippingCustomizationOptions;

/**
 * Class Data
 * todo: What is its purpose? What does it do?
 *
 * @package Eleanorsoft\ShippingMethod\Helper
 * @author Konstantin Esin <hello@eleanorsoft.com>
 * @copyright Copyright (c) 2017 Eleanorsoft (https://www.eleanorsoft.com/)
 */
class Data extends AbstractHelper
{
    public function isFreightProduct($item)
    {
        $product = $item->getProduct();

        if (is_null($product)) {
            return false;
        }

        return $product->getShippingType() == ShippingCustomizationOptions::FREIGHT;
    }
}
