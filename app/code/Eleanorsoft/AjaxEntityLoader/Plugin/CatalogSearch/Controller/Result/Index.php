<?php

namespace Eleanorsoft\AjaxEntityLoader\Plugin\CatalogSearch\Controller\Result;
use Eleanorsoft\AjaxEntityLoader\Plugin\AjaxEntityLoader;


/**
 * Class Index
 * todo: What is its purpose? What does it do?
 *
 * @package Eleanorsoft_
 * @author Pisarenko Denis <denis.pisarenko@eleanorsoft.com>
 * @copyright Copyright (c) 2018 Eleanorsoft (https://www.eleanorsoft.com/)
 */

class Index extends AjaxEntityLoader
{

    /**
     * Get name block
     *
     * @return string
     */
    protected function getTitleBlock()
    {
        return 'search_result_list';
    }

    protected function beforeHtml()
    {
//        $layout = $this->getLayout();
//        $layout->unsetElement('product_list_toolbar');
//
//        $block = $this->getBlock('product_list_toolbar');
//        $block->setTemplate('');
    }
}