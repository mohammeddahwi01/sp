<?php
/**
 * @author Amasty Team
 * @copyright Copyright (c) 2016 Amasty (https://www.amasty.com)
 * @package Amasty_Shopby
 */

namespace Amasty\Shopby\Block\Navigation;


use Magento\Framework\View\Element\Template;

class Init extends \Magento\Framework\View\Element\Template
{
    /**
     * Constructor
     *
     * @param Template\Context $context
     * @param array $data
     */
    public function __construct(
        Template\Context $context,
        \Amasty\Shopby\Model\Category\Manager\Proxy $categoryManager,
        array $data = []
    ){
        $categoryManager->init();

        return parent::__construct($context, $data);
    }
}