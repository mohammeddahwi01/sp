<?php

namespace Eleanorsoft\HelpMenu\Block;

use \Magento\Customer\Block\Form\Login;
use \Magento\Framework\View\Element\Template;

class Menu extends Template
{
    protected $cmsPage;

    public function __construct(
        Template\Context $context,
        \Magento\Cms\Model\Page $cmsPage,
        array $data = []
    ) {
        $this->cmsPage = $cmsPage;
        parent::__construct($context, $data);
    }

    public function getActiveItem()
    {
        if ($this->getData('active_item')) {
            return $this->getData('active_item');
        }
        return $this->cmsPage->getIdentifier();
    }
}
