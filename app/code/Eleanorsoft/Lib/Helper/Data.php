<?php

namespace Eleanorsoft\Lib\Helper;

use \Magento\Store\Model\ScopeInterface;
use \Magento\Framework\App\Helper\Context;
use \Magento\Framework\App\Helper\AbstractHelper;
use \Magento\Backend\Helper\Data as BackendHelper;
use \Magento\Framework\App\Config\Storage\WriterInterface;
use \Magento\Framework\App\Config\ReinitableConfigInterface;

/**
 * Class Data
 * Module general config.
 *
 * @package Eleanorsoft\Lib\Model
 * @author Eugene Polischuk <eugene.polischuk@eleanorsoft.com>
 * @copyright Copyright (c) 2017 Eleanorsoft (https://www.eleanorsoft.com/)
 */
class Data extends AbstractHelper
{
    /**
     * Config is enabled field value.
     */
    static $IS_ENABLED_FIELD = 'enabled';

    /**
     * Module name.
     *
     * @var string
     */
    protected $moduleName;

    /**
     * Default config group.
     *
     * @var string
     */
    protected $defaultGroup;

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

        $this->_construct();
        parent::__construct($context);
    }

    /**
     * Pseudo constructor for additional configuration.
     *
     * @author Eugene Polischuk <eugene.polischuk@eleanorsoft.com>
     */
    public function _construct()
    {
        $this->setDefaultGroup('general');
        $this->setModuleName('eleanorsoft_lib');
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
        return $this->getPath(self::$IS_ENABLED_FIELD);
    }

    /**
     * Get config is enabled value.
     *
     * @return boolean
     * @author Eugene Polischuk <eugene.polischuk@eleanorsoft.com>
     */
    public function getIsEnabledValue()
    {
        return (bool)$this->getValue($this->getIsEnabledPath());
    }

    /**
     * Get if module is enabled.
     *
     * @return boolean
     * @author Eugene Polischuk <eugene.polischuk@eleanorsoft.com>
     */
    public function isModuleEnabled()
    {
        return (bool)($this->getIsEnabledValue() && $this->isModuleOutputEnabled());
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
     * Get config value.
     *
     * @param $path
     * @param string $scope
     * @return mixed
     * @author Eugene Polischuk <eugene.polischuk@eleanorsoft.com>
     */
    public function getValue($path, $scope = ScopeInterface::SCOPE_STORE)
    {
        return $this->scopeConfig->getValue($path, $scope);
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
        $this->configWriter->save($path, $value);
    }

    /**
     * Delete config value.
     *
     * @param $path
     * @author Eugene Polischuk <eugene.polischuk@eleanorsoft.com>
     */
    public function deleteByPath($path)
    {
        $this->configWriter->delete($path);
    }

    /**
     * Get config path.
     *
     * @param $value
     * @param string $group
     * @return string
     * @author Eugene Polischuk <eugene.polischuk@eleanorsoft.com>
     */
    public function getPath($value, $group = null)
    {
        $group = $group ?: $this->getDefaultGroup();

        return $this->getModuleName() . "/$group/$value";
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
        $string = trim($string);

        return $string;
    }

    /**
     * Get default config group.
     *
     * @return string
     * @author Eugene Polischuk <eugene.polischuk@eleanorsoft.com>
     */
    public function getDefaultGroup()
    {
        return $this->defaultGroup;
    }

    /**
     * Set default config group.
     *
     * @param string $defaultGroup
     * @author Eugene Polischuk <eugene.polischuk@eleanorsoft.com>
     */
    public function setDefaultGroup($defaultGroup)
    {
        $this->defaultGroup = $defaultGroup;
    }

    /**
     * Get module name.
     *
     * @return string
     * @author Eugene Polischuk <eugene.polischuk@eleanorsoft.com>
     */
    public function getModuleName()
    {
        return $this->moduleName;
    }

    /**
     * Set module name.
     *
     * @param string $moduleName
     * @author Eugene Polischuk <eugene.polischuk@eleanorsoft.com>
     */
    public function setModuleName($moduleName)
    {
        $this->moduleName = $moduleName;
    }
}
