<?php

namespace Eleanorsoft\AddThis\Block;

use Magento\Framework\Registry;
use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;
use Magento\Store\Model\ScopeInterface;

/**
 * Class Widget
 * AddThis widget class.
 *
 * @package Eleanorsoft\AddThis\Block
 * @author Eugene Polischuk <eugene.polischuk@eleanorsoft.com>
 * @copyright Copyright (c) 2018 Eleanorsoft (https://www.eleanorsoft.com/)
 */
class Widget extends Template
{

    const ADDTHIS_WIDGET = '//s7.addthis.com/js/300/addthis_widget.js#pubid=';
    /**
     * @var Registry
     */
    protected $registry;

    /**
     * Widget constructor.
     *
     * @param Context $context
     * @param Registry $registry
     * @param array $data
     * @author Eugene Polischuk <eugene.polischuk@eleanorsoft.com>
     */
    public function __construct(
        Context $context,
        Registry $registry,
        array $data = []
    ) {
        $this->registry = $registry;

        parent::__construct(
            $context,
            $data
        );
    }

    /**
     * @author Eugene Polischuk <eugene.polischuk@eleanorsoft.com>
     */
    public function _construct()
    {
        parent::_construct();
        $account_id = self::ADDTHIS_WIDGET . $this->_scopeConfig->getValue('addthis/options/account_id', ScopeInterface::SCOPE_STORE);
        $this->setScriptUrl($account_id);
    }

    /**
     * Get script url.
     *
     * @return string
     * @author Eugene Polischuk <eugene.polischuk@eleanorsoft.com>
     */
    public function getScriptUrl()
    {
        return $this->getData('script_url');
    }

    /**
     * Set script url.
     *
     * @param $scriptUrl
     * @return $this
     * @author Eugene Polischuk <eugene.polischuk@eleanorsoft.com>
     */
    public function setScriptUrl($scriptUrl)
    {
        $this->setData('script_url', $scriptUrl);

        return $this;
    }

    /**
     * Get is script already loaded.
     *
     * @return bool
     * @author Eugene Polischuk <eugene.polischuk@eleanorsoft.com>
     */
    public function isScriptAlreadyLoaded()
    {
        return (bool)$this->registry->registry('is_addthis_script_loaded');
    }

    /**
     * Set is script already loaded.
     *
     * @param bool $value
     * @return $this
     * @author Eugene Polischuk <eugene.polischuk@eleanorsoft.com>
     */
    public function setScriptAlreadyLoaded($value = true)
    {
        $this->registry->register('is_addthis_script_loaded', (bool)$value);

        return $this;
    }

    /**
     * Get widget renderer container html.
     *
     * @return string
     * @author Eugene Polischuk <eugene.polischuk@eleanorsoft.com>
     */
    public function getWidgetRendererHtml()
    {
        return '<div class="addthis_inline_share_toolbox"></div>';
    }

    /**
     * Get widget html.
     * Without template, because it can be cached in layout.
     *
     * @return string
     * @author Eugene Polischuk <eugene.polischuk@eleanorsoft.com>
     */
    public function getWidgetHtml()
    {
        $html = $this->getWidgetRendererHtml();

        if (!$this->isScriptAlreadyLoaded()) {
            $this->setScriptAlreadyLoaded();

            $html .= '<script type="text/javascript" src="' . $this->getScriptUrl() . '"></script>';
        }

        return $html;
    }

    /**
     * Get widget script html.
     *
     * @return string
     */
    public function getWidgetScript()
    {
        $html = '';
        if (!$this->isScriptAlreadyLoaded()) {
            $this->setScriptAlreadyLoaded();

            $html .= '<script type="text/javascript" src="' . $this->getScriptUrl() . '"></script>';
        }

        return $html;
    }
}
