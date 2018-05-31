<?php

namespace Eleanorsoft\AjaxEntityLoader\Block;

use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;

class Loader extends Template
{

    /**
     * @var array
     */
    protected $layoutProcessors;

    /**
     * Loader constructor.
     * @param Context $context
     * @param array $layoutProcessors
     * @param array $data
     */
    public function __construct
    (
        Context $context,
        array $layoutProcessors = [],
        array $data = []
    )
    {
        parent::__construct($context, $data);
        $this->layoutProcessors = $layoutProcessors;
    }

    /**
     * Retrieve serialized JS layout configuration ready to use in template
     *
     * @return string
     */
    public function getJsLayout()
    {
        foreach ($this->layoutProcessors as $processor) {
            $this->jsLayout = $processor->process($this->jsLayout);

        }
        return parent::getJsLayout();
    }
}
