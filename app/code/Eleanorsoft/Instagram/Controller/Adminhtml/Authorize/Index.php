<?php

namespace Eleanorsoft\Instagram\Controller\Adminhtml\Authorize;

use \Exception;
use \Magento\Backend\App\Action;
use \Magento\Backend\App\Action\Context;
use \Magento\Framework\Controller\ResultFactory;
use \Eleanorsoft\Instagram\Helper\Config as ModuleConfig;
use \Eleanorsoft\Instagram\Instagram\Api\Adapter\AdapterInterface as InstagramApiInterface;

/**
 * Class Index
 * Instagram token saver.
 *
 * @package Eleanorsoft\Instagram\Controller\Adminhtml\Authorize
 * @author Eugene Polischuk <eugene.polischuk@eleanorsoft.com>
 * @copyright Copyright (c) 2017 Eleanorsoft (https://www.eleanorsoft.com/)
 */
class Index extends Action
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
     * @var array
     */
    protected $_publicActions = ['index'];

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
        $oAuthCode = $this->getRequest()->getParam('code');

        if (isset($oAuthCode)) {
            $data = $this->instagramApi->getOAuthToken($oAuthCode);

            if (isset($data->access_token)) {
                $this->moduleConfig->setTokenValue($data->access_token);
                $this->moduleConfig->deleteError();
                $this->messageManager->addSuccessMessage(
                    __('Instagram account has been connected successfully.')
                );
                $this->messageManager->addSuccessMessage(__('Please, clean cache.'));
            } else {
                $error = __('Instagram access token is not set.');

                $this->moduleConfig->setErrorValue($error);
                $this->messageManager->addErrorMessage($error);

                if ($data->error_message) {
                    $this->messageManager->addErrorMessage($data->error_message);
                }
            }
        } else {
            $error = __('Instagram authorization code is not set.');

            $this->moduleConfig->setErrorValue($error);
            $this->messageManager->addErrorMessage($error);
        }

        $this->moduleConfig->refreshConfig();

        return $this->resultFactory->create(ResultFactory::TYPE_REDIRECT)
            ->setUrl(
                $this->_url->getUrl(
                    'adminhtml/system_config/edit/section/' . ModuleConfig::SECTION
                )
            );
    }
}
