<?php

namespace Eleanorsoft\Lib\Helper;

use Magento\Store\Model\ScopeInterface;
use Magento\Framework\App\Helper\Context;
use Magento\Framework\App\Helper\AbstractHelper;
use Amasty\InvisibleCaptcha\Helper\Data as AmastyHelper;

/**
 * Class Captcha
 * Captcha helper class.
 *
 * @package Eleanorsoft\Lib\Helper
 * @author Eugene Polischuk <eugene.polischuk@eleanorsoft.com>
 * @copyright Copyright (c) 2017 Eleanorsoft (https://www.eleanorsoft.com/)
 */
class Captcha extends AbstractHelper
{
    /**
     * Helper field name.
     */
    const HELPER_FIELD_NAME = 'captcha_helper';

    /**
     * @var AmastyHelper
     */
    protected $amastyHelper;

    /**
     * Captcha constructor.
     *
     * @param Context $context
     * @param AmastyHelper $amastyHelper
     * @author Eugene Polischuk <eugene.polischuk@eleanorsoft.com>
     */
    public function __construct(
        Context $context,
        AmastyHelper $amastyHelper
    ) {
        $this->amastyHelper = $amastyHelper;

        parent::__construct($context);
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
}
