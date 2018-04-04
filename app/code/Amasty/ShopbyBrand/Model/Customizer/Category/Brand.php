<?php
/**
 * @author Amasty Team
 * @copyright Copyright (c) 2016 Amasty (https://www.amasty.com)
 * @package Amasty_Shopby
 */

/**
 * Copyright © 2016 Amasty. All rights reserved.
 */
namespace Amasty\ShopbyBrand\Model\Customizer\Category;

use Amasty\Shopby\Model\Customizer\Category\CustomizerInterface;
use Magento\Catalog\Model\Category;
use Amasty\ShopbyBrand\Helper\Content;

class Brand implements CustomizerInterface
{
    /** @var  Content */
    protected $_contentHelper;

    /**
     * @param Content $contentHelper
     */
    public function __construct(Content $contentHelper)
    {
        $this->_contentHelper = $contentHelper;
    }

    /**
     * @param Category $category
     */
    public function prepareData(Category $category)
    {
        $this->_contentHelper->setCategoryData($category);
    }
}