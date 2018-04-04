<?php

namespace Eleanorsoft\CustomForm\Block;

use Magento\Store\Model\ScopeInterface;
use Magento\Framework\View\Element\Template;
use Amasty\InvisibleCaptcha\Helper\Data as AmastyHelper;
use Magento\Framework\View\Element\Template\Context as TemplateContext;

/**
 * Class BlockForm
 *
 * @package Eleanorsoft_CustomForm
 * @author Pisarenko Denis <denis.pisarenko@eleanorsoft.com>
 * @copyright Copyright (c) 2018 Eleanorsoft (https://www.eleanorsoft.com/)
 */

class BlockForm extends Template
{
    /**
     * @var AmastyHelper
     */
    protected $amastyHelper;

    /**
     * BlockForm constructor.
     *
     * @param TemplateContext $context
     * @param AmastyHelper $amastyHelper
     * @param array $data
     * @author Pisarenko Denis <denis.pisarenko@eleanorsoft.com>
     */
    public function __construct(
        TemplateContext $context,
        AmastyHelper $amastyHelper,
        array $data = []
    ) {
        $this->_isScopePrivate = true;
        $this->amastyHelper = $amastyHelper;

        parent::__construct(
            $context,
            $data
        );
    }

    /**
     * URL where custom form will be submitted to.
     * Should be overridden in child modules. See examples.
     *
     * @return string
     * @author Pisarenko Denis <denis.pisarenko@eleanorsoft.com>
     * @copyright Copyright (c) 2018 Eleanorsoft (https://www.eleanorsoft.com/)
     */
    public function getFormAction()
    {
        return $this->getUrl($this->getData('custom_form_action'), ['_secure' => true]);
    }

    /**
     * Get captcha site key.
     *
     * @return string
     * @author Eugene Polischuk <eugene.polischuk@eleanorsoft.com>
     */
    public function getCaptchaSiteKey()
    {
        return $this->amastyHelper->getConfigValueByPath(
            AmastyHelper::CONFIG_PATH_GENERAL_SITE_KEY,
            null,
            ScopeInterface::SCOPE_STORE
        );
    }
    
    /**
     * Get captcha script url.
     *
     * @return string
     * @author Eugene Polischuk <eugene.polischuk@eleanorsoft.com>
     */
    public function getCaptchaScriptUrl()
    {
        return 'https://www.google.com/recaptcha/api.js';
    }
}
