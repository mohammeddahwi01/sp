<?php

namespace Eleanorsoft\CustomForm\Controller;

use Eleanorsoft\CustomForm\Helper\CustomFormHelperInterface;
use Eleanorsoft\CustomForm\Model\Mail\TransportBuilder;
use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Translate\Inline\StateInterface;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Framework\Exception\NotFoundException;
/**
 * Class Index
 *
 * @package Eleanorsoft_CustomForm
 * @author Pisarenko Denis <denis.pisarenko@eleanorsoft.com>
 * @copyright Copyright (c) 2018 Eleanorsoft (https://www.eleanorsoft.com/)
 */

abstract class Index extends Action
{
    /**
     * @var TransportBuilder
     */
    protected $transportBuilder;

    /**
     * @var StateInterface
     */
    protected $inlineTranslation;

    /**
     * @var ScopeConfigInterface
     */
    protected $scopeConfig;

    /**
     * @var StoreManagerInterface
     */
    protected $storeManager;

    /**
     * @var CustomFormHelperInterface
     */
    protected $customFormHelper;

    /**
     * @param Context $context
     * @param TransportBuilder $transportBuilder
     * @param StateInterface $inlineTranslation
     * @param ScopeConfigInterface $scopeConfig
     * @param StoreManagerInterface $storeManager
     * @param CustomFormHelperInterface $customFormHelper
     */
    public function __construct(
        Context $context,
        TransportBuilder $transportBuilder,
        StateInterface $inlineTranslation,
        ScopeConfigInterface $scopeConfig,
        StoreManagerInterface $storeManager,
        CustomFormHelperInterface $customFormHelper
    )
    {
        parent::__construct($context);
        $this->transportBuilder = $transportBuilder;
        $this->inlineTranslation = $inlineTranslation;
        $this->scopeConfig = $scopeConfig;
        $this->storeManager = $storeManager;
        $this->customFormHelper = $customFormHelper;
    }

    /**
     * Dispatch request
     * Check if module is enabled.
     * Otherwise throw error 404.
     *
     * @param RequestInterface $request
     * @return ResponseInterface
     * @throws NotFoundException
     * @author Pisarenko Denis <denis.pisarenko@eleanorsoft.com>
     * @copyright Copyright (c) 2018 Eleanorsoft (https://www.eleanorsoft.com/)
     */
    public function dispatch(RequestInterface $request)
    {
        if (!$this->customFormHelper->isEnabled()) {
            throw new NotFoundException(__('Page not found.'));
        }
        return parent::dispatch($request);
    }
}