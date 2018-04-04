<?php
/**
 * @author Amasty Team
 * @copyright Copyright (c) 2018 Amasty (https://www.amasty.com)
 * @package Amasty_InvisibleCaptcha
 */


namespace Amasty\InvisibleCaptcha\Helper;

use Magento\Framework\App\Helper\AbstractHelper;

class Data extends AbstractHelper
{
    const CONFIG_PATH_GENERAL_ENABLE_MODULE = 'aminvisiblecaptcha/general/enabledCaptcha';

    const CONFIG_PATH_GENERAL_SITE_KEY = 'aminvisiblecaptcha/general/captchaKey';

    const CONFIG_PATH_GENERAL_SECRET_KEY = 'aminvisiblecaptcha/general/captchaSecret';

    const CONFIG_PATH_GENERAL_ALLOWED_URLS = 'aminvisiblecaptcha/general/captchaUrls';

    const CONFIG_PATH_DISPLAY_ALLOWED_SELECTORS = 'aminvisiblecaptcha/general/captchaSelectors';

    /**
     * @var \Magento\Framework\App\Config\ScopeConfigInterface|null
     */
    protected $_scopeConfig = null;

    /**
     * Data constructor.
     * @param \Magento\Framework\App\Helper\Context $context
     */
    public function __construct(
        \Magento\Framework\App\Helper\Context $context
    ) {
        parent::__construct($context);
        $this->_scopeConfig = $context->getScopeConfig();
    }

    /**
     * @param $string
     * @return mixed
     */
    public function stringValidationAndCovertInArray($string)
    {
        $validate = function ($urls) {
            return preg_split('|\s*[\r\n]+\s*|', $urls, -1, PREG_SPLIT_NO_EMPTY);
        };

        return $validate($string);
    }

    /**
     * @return bool
     */
    public function isModuleOn()
    {
        return $this->getConfigValueByPath(
            self::CONFIG_PATH_GENERAL_ENABLE_MODULE,
            null,
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        ) ? true : false;
    }

    /**
     * @param $path
     * @param null $storeId
     * @param string $scope
     * @return mixed
     */
    public function getConfigValueByPath(
        $path,
        $storeId = null,
        $scope = \Magento\Store\Model\ScopeInterface::SCOPE_STORE
    ) {
        return $this->_scopeConfig->getValue($path, $scope, $storeId);
    }

    /**
     * @return array
     */
    public function getCaptchaUrls()
    {
        $urls = trim($this->getConfigValueByPath(self::CONFIG_PATH_GENERAL_ALLOWED_URLS));

        return $urls ? $this->stringValidationAndCovertInArray($urls) : [];
    }
}
