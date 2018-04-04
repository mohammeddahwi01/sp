<?php

namespace Eleanorsoft\Instagram\Block\System\Config\Form;

use \Magento\Backend\Block\Template\Context;
use \Magento\Config\Block\System\Config\Form\Field;
use \Magento\Framework\Data\Form\Element\AbstractElement;
use \Eleanorsoft\Instagram\Helper\Config as ModuleConfig;
use \Eleanorsoft\Instagram\Instagram\Api\Adapter\AdapterInterface as InstagramApiInterface;

/**
 * Class AuthorizeButton
 * Instagram authorize button renderer.
 *
 * @author Eugene Polischuk <eugene.polischuk@eleanorsoft.com>
 * @copyright Copyright (c) 2017 Eleanorsoft (https://www.eleanorsoft.com/)
 */
class AuthorizeButton extends Field
{
    /**
     * @var string
     */
    protected $_template = 'system/config/button/authorize.phtml';

    /**
     * @var ModuleConfig
     */
    protected $moduleConfig;

    /**
     * @var InstagramApiInterface
     */
    protected $instagramApi;

    /**
     * AuthorizeButton constructor.
     *
     * @param Context $context
     * @param ModuleConfig $moduleConfig
     * @param InstagramApiInterface $instagramApi
     * @param array $data
     * @author Eugene Polischuk <eugene.polischuk@eleanorsoft.com>
     */
    public function __construct(
        Context $context,
        ModuleConfig $moduleConfig,
        InstagramApiInterface $instagramApi,
        array $data = []
    ) {
        $this->moduleConfig = $moduleConfig;
        $this->instagramApi = $instagramApi;

        parent::__construct($context, $data);
    }

    /**
     * Remove scope label.
     *
     * @param  AbstractElement $element
     * @return string
     */
    public function render(AbstractElement $element)
    {
        $element->unsScope()
                ->unsCanUseWebsiteValue()
                ->unsCanUseDefaultValue();

        return parent::render($element);
    }

    /**
     * Return element html.
     *
     * @param  AbstractElement $element
     * @return string
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    protected function _getElementHtml(AbstractElement $element)
    {
        return $this->_toHtml();
    }

    /**
     * Get button html id.
     *
     * @return string
     * @author Eugene Polischuk <eugene.polischuk@eleanorsoft.com>
     */
    public function getButtonHtmlId()
    {
        return 'instagram_authorize_button';
    }

    /**
     * Get Instagram callback url.
     *
     * @return string
     * @author Eugene Polischuk <eugene.polischuk@eleanorsoft.com>
     */
    public function getApiCallbackUrl()
    {
        return $this->moduleConfig->getApiCallbackUrl();
    }

    /**
     * Get Instagram connect url.
     *
     * @return string
     * @author Eugene Polischuk <eugene.polischuk@eleanorsoft.com>
     */
    public function getApiConnectUrl()
    {
        return $this->moduleConfig->getApiConnectUrl();
    }
}
