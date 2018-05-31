<?php

namespace Eleanorsoft\AjaxEntityLoader\Plugin\Catalog\Controller\Category;
use Eleanorsoft\AjaxEntityLoader\Plugin\AjaxEntityLoader;


/**
 * Class Index
 * todo: What is its purpose? What does it do?
 *
 * @package Eleanorsoft_
 * @author Pisarenko Denis <denis.pisarenko@eleanorsoft.com>
 * @copyright Copyright (c) 2018 Eleanorsoft (https://www.eleanorsoft.com/)
 */

class View extends AjaxEntityLoader
{

    /**
     * Name block
     *
     * @return string
     */
    protected function getTitleBlock()
    {
        return 'category.products.list';
    }

    protected function beforeHtml()
    {
        $block = $this->getBlock('product_list_toolbar');
        $block->setTemplate('');
    }
}