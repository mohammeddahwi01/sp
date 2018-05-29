<?php

namespace Eleanorsoft\Instagram\Plugin;

use \Magento\Backend\Block\Page\Notices;
use \Magento\Framework\Message\ManagerInterface;
use \Magento\Backend\Helper\Data as BackendHelper;
use \Magento\Framework\App\Request\Http as HttpRequest;
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
     * @var HttpRequest
     */
    protected $request;

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
     * @param HttpRequest $request
     * @param ModuleConfig $moduleConfig
     * @param BackendHelper $backendHelper
     * @param ManagerInterface $messageManager
     * @author Eugene Polischuk <eugene.polischuk@eleanorsoft.com>
     */
    public function __construct(
        HttpRequest $request,
        ModuleConfig $moduleConfig,
        BackendHelper $backendHelper,
        ManagerInterface $messageManager
    ) {
        $this->request = $request;
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
        $storeId = $this->request->getParam('store');

        $this->moduleConfig->setStoreId($storeId);

        $token = $this->moduleConfig->getTokenValue();
        $error = $this->moduleConfig->getErrorValue();
        $sectionUrl = $this->backendHelper->getUrl(
            'adminhtml/system_config/edit',
            [
                'section' => ModuleConfig::SECTION,
                'store' => $storeId
            ]
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
