<?php

namespace Eleanorsoft\Instagram\Controller\Adminhtml\Authorize;

use \Magento\Backend\App\Action;
use \Magento\Backend\App\Action\Context;
use \Magento\Framework\Controller\ResultFactory;
use \Eleanorsoft\Instagram\Helper\Config as ModuleConfig;
use \Eleanorsoft\Instagram\Instagram\Api\Adapter\AdapterInterface as InstagramApiInterface;

/**
 * Class Connect
 * Instagram connect action.
 *
 * @package Eleanorsoft\Instagram\Controller\Adminhtml\Authorize
 * @author Eugene Polischuk <eugene.polischuk@eleanorsoft.com>
 * @copyright Copyright (c) 2017 Eleanorsoft (https://www.eleanorsoft.com/)
 */
class Connect extends Action
{
    /**
     * @var ModuleConfig
     */
    protected $moduleConfig;

    /**
     * @var InstagramApiInterface
     */
    protected $instagramApi;

    /**
     * Index constructor.
     *
     * @param Context $context
     * @param ModuleConfig $moduleConfig
     * @param InstagramApiInterface $instagramApi
     * @author Eugene Polischuk <eugene.polischuk@eleanorsoft.com>
     */
    public function __construct(
        Context $context,
        ModuleConfig $moduleConfig,
        InstagramApiInterface $instagramApi
    ) {
        $this->moduleConfig = $moduleConfig;
        $this->instagramApi = $instagramApi;

        parent::__construct($context);
    }

    /**
     * @return mixed
     * @author Eugene Polischuk <eugene.polischuk@eleanorsoft.com>
     */
    public function execute()
    {
        $this->moduleConfig->deleteError();
        $this->moduleConfig->deleteToken();
        $this->moduleConfig->setClientIdValue(
            $this->getRequest()->getParam('client_id')
        );
        $this->moduleConfig->setClientSecretValue(
            $this->getRequest()->getParam('client_secret')
        );
        $this->moduleConfig->setIsEnabledValue(
            $this->getRequest()->getParam('is_enabled')
        );
        $this->moduleConfig->refreshConfig();

        return $this->resultFactory->create(ResultFactory::TYPE_REDIRECT)
            ->setUrl($this->instagramApi->getLoginUrl());
    }
}
