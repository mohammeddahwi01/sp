<?php

namespace Eleanorsoft\Instagram\Helper;

use \Magento\Store\Model\ScopeInterface;
use \Magento\Framework\App\Helper\Context;
use \Magento\Framework\App\Helper\AbstractHelper;
use \Magento\Backend\Helper\Data as BackendHelper;
use \Magento\Framework\App\Config\ScopeConfigInterface;
use \Magento\Framework\App\Config\Storage\WriterInterface;
use \Magento\Framework\App\Config\ReinitableConfigInterface;

/**
 * Class Config
 * Module general config.
 *
 * @package Eleanorsoft\Instagram\Model
 * @author Eugene Polischuk <eugene.polischuk@eleanorsoft.com>
 * @copyright Copyright (c) 2017 Eleanorsoft (https://www.eleanorsoft.com/)
 */
class Config extends AbstractHelper
{
    /**
     * Module name.
     */
    const MODULE_NAME = 'eleanorsoft_instagram';

    /**
     * Config error field value.
     */
    const ERROR_FIELD = 'error';

    /**
     * Config token field value.
     */
    const TOKEN_FIELD = 'token';

    /**
     * Config is enabled field value.
     */
    const IS_ENABLED_FIELD = 'is_enabled';

    /**
     * Config client id field value.
     */
    const CLIENT_ID_FIELD = 'client_id';

    /**
     * Config client secret field value.
     */
    const CLIENT_SECRET_FIELD = 'client_secret';

    /**
     * Config default group value.
     */
    const DEFAULT_GROUP = 'general';

    /**
     * Config section value.
     */
    const SECTION = 'eleanorsoft_instagram';

    /**
     * @var string
     */
    protected $storeId;

    /**
     * @var string
     */
    protected $storeScope;

    /**
     * @var BackendHelper
     */
    protected $backendHelper;

    /**
     * @var WriterInterface
     */
    protected $configWriter;

    /**
     * @var ReinitableConfigInterface
     */
    protected $reinitableConfig;

    /**
     * Config constructor.
     *
     * @param Context $context
     * @param WriterInterface $configWriter
     * @param ReinitableConfigInterface $reinitableConfig
     * @author Eugene Polischuk <eugene.polischuk@eleanorsoft.com>
     */
    public function __construct(
        Context $context,
        BackendHelper $backendHelper,
        WriterInterface $configWriter,
        ReinitableConfigInterface $reinitableConfig
    ) {
        $this->configWriter = $configWriter;
        $this->backendHelper = $backendHelper;
        $this->reinitableConfig = $reinitableConfig;

        parent::__construct($context);
        $this->_construct();
    }

    /**
     * Helper pseudo construct.
     *
     * @author Eugene Polischuk <eugene.polischuk@eleanorsoft.com>
     */
    public function _construct()
    {
        $this->setStoreId(null);
    }

    /**
     * Get store id.
     *
     * @return string
     * @author Eugene Polischuk <eugene.polischuk@eleanorsoft.com>
     */
    public function getStoreId()
    {
        return $this->storeId;
    }

    /**
     * Get store scope.
     *
     * @return string
     * @author Eugene Polischuk <eugene.polischuk@eleanorsoft.com>
     */
    public function getStoreScope()
    {
        return $this->storeScope;
    }

    /**
     * Set store id.
     *
     * @param $storeId
     * @author Eugene Polischuk <eugene.polischuk@eleanorsoft.com>
     */
    public function setStoreId($storeId)
    {
        $this->storeId = $storeId;
        $this->storeScope = $this->getStoreId() ?
            ScopeInterface::SCOPE_STORES :
            ScopeConfigInterface::SCOPE_TYPE_DEFAULT;
    }

    /**
     * Delete config error.
     *
     * @author Eugene Polischuk <eugene.polischuk@eleanorsoft.com>
     */
    public function deleteError()
    {
        $this->deleteByPath($this->getErrorPath());
    }

    /**
     * Get config error path.
     *
     * @return string
     * @author Eugene Polischuk <eugene.polischuk@eleanorsoft.com>
     */
    public function getErrorPath()
    {
        return $this->getPath(self::ERROR_FIELD);
    }

    /**
     * Get config error value.
     *
     * @return mixed
     * @author Eugene Polischuk <eugene.polischuk@eleanorsoft.com>
     */
    public function getErrorValue()
    {
        return $this->getValue($this->getErrorPath());
    }

    /**
     * Set config error value.
     *
     * @param $value
     * @author Eugene Polischuk <eugene.polischuk@eleanorsoft.com>
     */
    public function setErrorValue($value)
    {
        $this->setValue($this->getErrorPath(), $value);
    }

    /**
     * Delete config token.
     *
     * @author Eugene Polischuk <eugene.polischuk@eleanorsoft.com>
     */
    public function deleteToken()
    {
        $this->deleteByPath($this->getTokenPath());
    }

    /**
     * Get config token path.
     *
     * @return string
     * @author Eugene Polischuk <eugene.polischuk@eleanorsoft.com>
     */
    public function getTokenPath()
    {
        return $this->getPath(self::TOKEN_FIELD);
    }

    /**
     * Get config token value.
     *
     * @return mixed
     * @author Eugene Polischuk <eugene.polischuk@eleanorsoft.com>
     */
    public function getTokenValue()
    {
        return $this->getValue($this->getTokenPath());
    }

    /**
     * Set config token value.
     *
     * @param $value
     * @author Eugene Polischuk <eugene.polischuk@eleanorsoft.com>
     */
    public function setTokenValue($value)
    {
        $this->setValue($this->getTokenPath(), $value);
    }

    /**
     * Delete config is enabled.
     *
     * @author Eugene Polischuk <eugene.polischuk@eleanorsoft.com>
     */
    public function deleteIsEnabled()
    {
        $this->deleteByPath($this->getIsEnabledPath());
    }

    /**
     * Get config is enabled path.
     *
     * @return string
     * @author Eugene Polischuk <eugene.polischuk@eleanorsoft.com>
     */
    public function getIsEnabledPath()
    {
        return $this->getPath(self::IS_ENABLED_FIELD);
    }

    /**
     * Get config is enabled value.
     *
     * @return mixed
     * @author Eugene Polischuk <eugene.polischuk@eleanorsoft.com>
     */
    public function getIsEnabledValue()
    {
        return $this->getValue($this->getIsEnabledPath());
    }

    /**
     * Set config is enabled value.
     *
     * @param $value
     * @author Eugene Polischuk <eugene.polischuk@eleanorsoft.com>
     */
    public function setIsEnabledValue($value)
    {
        $this->setValue($this->getIsEnabledPath(), (bool)$value);
    }

    /**
     * Delete config client id.
     *
     * @author Eugene Polischuk <eugene.polischuk@eleanorsoft.com>
     */
    public function deleteClientId()
    {
        $this->deleteByPath($this->getClientIdPath());
    }

    /**
     * Get config client id path.
     *
     * @return string
     * @author Eugene Polischuk <eugene.polischuk@eleanorsoft.com>
     */
    public function getClientIdPath()
    {
        return $this->getPath(self::CLIENT_ID_FIELD);
    }

    /**
     * Get config client id value.
     *
     * @return mixed
     * @author Eugene Polischuk <eugene.polischuk@eleanorsoft.com>
     */
    public function getClientIdValue()
    {
        return $this->getValue($this->getClientIdPath());
    }

    /**
     * Set config client id value.
     *
     * @param $value
     * @author Eugene Polischuk <eugene.polischuk@eleanorsoft.com>
     */
    public function setClientIdValue($value)
    {
        $this->setValue($this->getClientIdPath(), $this->getClearedString($value));
    }

    /**
     * Delete config client secret.
     *
     * @author Eugene Polischuk <eugene.polischuk@eleanorsoft.com>
     */
    public function deleteClientSecret()
    {
        $this->deleteByPath($this->getClientSecretPath());
    }

    /**
     * Get config client secret path.
     *
     * @return string
     * @author Eugene Polischuk <eugene.polischuk@eleanorsoft.com>
     */
    public function getClientSecretPath()
    {
        return $this->getPath(self::CLIENT_SECRET_FIELD);
    }

    /**
     * Get config client secret value.
     *
     * @return mixed
     * @author Eugene Polischuk <eugene.polischuk@eleanorsoft.com>
     */
    public function getClientSecretValue()
    {
        return $this->getValue($this->getClientSecretPath());
    }

    /**
     * Set config client secret value.
     *
     * @param $value
     * @author Eugene Polischuk <eugene.polischuk@eleanorsoft.com>
     */
    public function setClientSecretValue($value)
    {
        $this->setValue($this->getClientSecretPath(), $this->getClearedString($value));
    }

    /**
     * Get config value.
     *
     * @param $path
     * @return mixed
     * @author Eugene Polischuk <eugene.polischuk@eleanorsoft.com>
     */
    public function getValue($path)
    {
        return $this->scopeConfig->getValue($path, $this->getStoreScope(), $this->getStoreId());
    }

    /**
     * Set config value.
     *
     * @param $path
     * @param $value
     * @author Eugene Polischuk <eugene.polischuk@eleanorsoft.com>
     */
    public function setValue($path, $value)
    {
        $this->configWriter->save($path, $value, $this->getStoreScope(), $this->getStoreId());
    }

    /**
     * Delete config value.
     *
     * @param $path
     * @author Eugene Polischuk <eugene.polischuk@eleanorsoft.com>
     */
    public function deleteByPath($path)
    {
        $this->configWriter->delete($path, $this->getStoreScope(), $this->getStoreId());
    }

    /**
     * Get config path.
     *
     * @param $value
     * @param string $group
     * @return string
     * @author Eugene Polischuk <eugene.polischuk@eleanorsoft.com>
     */
    public function getPath($value, $group = self::DEFAULT_GROUP)
    {
        return self::SECTION . "/$group/$value";
    }

    /**
     * Refresh config data.
     *
     * @author Eugene Polischuk <eugene.polischuk@eleanorsoft.com>
     */
    public function refreshConfig()
    {
        $this->reinitableConfig->reinit();
    }

    /**
     * Get cleared string
     *
     * @param $string
     * @return string
     * @author Eugene Polischuk <eugene.polischuk@eleanorsoft.com>
     */
    public function getClearedString($string)
    {
        return trim($string);
    }

    /**
     * Get Instagram connect url.
     *
     * @return string
     * @author Eugene Polischuk <eugene.polischuk@eleanorsoft.com>
     */
    public function getApiConnectUrl()
    {
        return $this->backendHelper->getUrl(self::MODULE_NAME . '/authorize/connect');
    }

    /**
     * Get Instagram callback url.
     *
     * @return string
     * @author Eugene Polischuk <eugene.polischuk@eleanorsoft.com>
     */
    public function getApiCallbackUrl()
    {
        $url = $this->backendHelper->getUrl(self::MODULE_NAME . '/authorize/index');

        $urlParts = explode('key', $url);
        $resultUrl = reset($urlParts);
        $resultUrl .= 'store/' . $this->getStoreId();

        return $resultUrl;
    }
}
