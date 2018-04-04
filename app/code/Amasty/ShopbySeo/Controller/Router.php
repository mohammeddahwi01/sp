<?php
/**
 * @author Amasty Team
 * @copyright Copyright (c) 2016 Amasty (https://www.amasty.com)
 * @package Amasty_Shopby
 */


namespace Amasty\ShopbySeo\Controller;


use Amasty\ShopbySeo\Helper\Url;
use Amasty\ShopbySeo\Helper\UrlParser;
use Magento\UrlRewrite\Model\UrlFinderInterface;
use Magento\UrlRewrite\Service\V1\Data\UrlRewrite;

class Router implements \Magento\Framework\App\RouterInterface
{
    /** @var \Magento\Framework\App\ActionFactory */
    protected $actionFactory;

    /** @var \Magento\Framework\App\ResponseInterface */
    protected $_response;

    /** @var  Url */
    protected $urlHelper;

    /** @var  \Magento\Framework\Registry */
    protected $registry;

    /** @var  UrlParser */
    protected $urlParser;

    /** @var  UrlFinderInterface */
    protected $urlFinder;

    public function __construct(
        \Magento\Framework\App\ActionFactory $actionFactory,
        \Magento\Framework\App\ResponseInterface $response,
        \Magento\Framework\Registry $registry,
        UrlParser $urlParser,
        Url $urlHelper,
        UrlFinderInterface $urlFinder
    ) {
        $this->actionFactory = $actionFactory;
        $this->_response = $response;
        $this->registry = $registry;
        $this->urlHelper = $urlHelper;
        $this->urlParser = $urlParser;
        $this->urlFinder = $urlFinder;
    }

    public function match(\Magento\Framework\App\RequestInterface $request)
    {
        if (!$this->urlHelper->isSeoUrlEnabled()) {
            return;
        }

        $identifier = trim($request->getPathInfo(), '/');
        if (!preg_match('@^(.*)/([^/]+)@', $identifier, $matches))
            return;

        $seoPart = $this->urlHelper->removeCategorySuffix($matches[2]);
        $category = ($seoPart == $matches[2]) ? $matches[1] : $this->urlHelper->addCategorySuffix($matches[1]);

        $params = $this->urlParser->parseSeoPart($seoPart);
        if ($params === false) {
            return;
        }

        $rewrite = $this->urlFinder->findOneByData([
            UrlRewrite::REQUEST_PATH => $category,
        ]);

        if ($rewrite) {
            $this->registry->register('amasty_shopby_seo_parsed_params', $params);
            $request->setParams($params);
            $request->setPathInfo($category);
            return $this->actionFactory->create('Magento\Framework\App\Action\Forward');
        }
    }

}
