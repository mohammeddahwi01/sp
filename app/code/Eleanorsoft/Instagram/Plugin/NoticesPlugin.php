<?php

namespace Eleanorsoft\Instagram\Plugin;

use \Magento\Backend\Block\Page\Notices;
use \Magento\Framework\Message\ManagerInterface;
use \Magento\Backend\Helper\Data as BackendHelper;
use \Eleanorsoft\Instagram\Helper\Config as ModuleConfig;

/**
 * Class NoticesPlugin
 *
 * @package Eleanorsoft\Instagram\Model
 * @author Eugene Polischuk <eugene.polischuk@eleanorsoft.com>
 * @copyright Copyright (c) 2017 Eleanorsoft (https://www.eleanorsoft.com/)
 */
class NoticesPlugin
{
    /**
     * @var ModuleConfig
     */
    protected $moduleConfig;

    /**
     * @var BackendHelper
     */
    protected $backendHelper;

    /**
     * @var ManagerInterface
     */
    protected $messageManager;

    /**
     * NoticesPlugin constructor.
     *
     * @param ModuleConfig $moduleConfig
     * @param ManagerInterface $messageManager
     * @author Eugene Polischuk <eugene.polischuk@eleanorsoft.com>
     */
    public function __construct(
        ModuleConfig $moduleConfig,
        BackendHelper $backendHelper,
        ManagerInterface $messageManager
    ) {
        $this->moduleConfig = $moduleConfig;
        $this->backendHelper = $backendHelper;
        $this->messageManager = $messageManager;
    }

    /**
     * @param Notices $subject
     * @author Eugene Polischuk <eugene.polischuk@eleanorsoft.com>
     */
    public function afterDisplayNoscriptNotice(Notices $subject)
    {
        $token = $this->moduleConfig->getTokenValue();
        $error = $this->moduleConfig->getErrorValue();
        $sectionUrl = $this->backendHelper->getUrl(
            'adminhtml/system_config/edit/section/' . ModuleConfig::SECTION
        );
        $sectionHtml = '<a href="'.$sectionUrl.'">'.__('Correct it here.').'</a>';

        if (!$token) {
            $this->messageManager->addWarning(
                __('Instagram token is not set.'). " $sectionHtml"
            );
        }

        if ($error && $token) {
            $this->messageManager->addError("$error $sectionHtml");
        }
    }
}
