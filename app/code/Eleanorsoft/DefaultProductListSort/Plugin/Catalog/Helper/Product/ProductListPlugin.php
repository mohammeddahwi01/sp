<?php

namespace Eleanorsoft\DefaultProductListSort\Plugin\Catalog\Helper\Product;


/**
 * Class ProductListPlugin
 * Override default sort order in product list
 *
 * @package Eleanorsoft_DefaultProductListSort
 * @author Konstantin Esin <hello@eleanorsoft.com>
 * @copyright Copyright (c) 2017 Eleanorsoft (https://www.eleanorsoft.com/)
 */

class ProductListPlugin
{
    public function afterGetDefaultSortField(\Magento\Catalog\Helper\Product\ProductList $subject, $result)
    {
        return 'name';
    }
	
}