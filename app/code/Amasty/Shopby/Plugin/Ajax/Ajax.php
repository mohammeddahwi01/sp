<?php
/**
 * @author Amasty Team
 * @copyright Copyright (c) 2016 Amasty (https://www.amasty.com)
 * @package Amasty_Shopby
 */

/**
 * Copyright © 2016 Amasty. All rights reserved.
 */

namespace Amasty\Shopby\Plugin\Ajax;


class Ajax
{
    /**
     * @var \Amasty\Shopby\Helper\Data
     */
    protected $helper;

    /**
     * @var \Magento\Framework\Controller\Result\RawFactory
     */
    protected $resultRawFactory;

    /** @var \Amasty\Shopby\Helper\UrlBuilder  */
    protected $urlBuilder;

    /**
     * CategoryViewAjax constructor.
     *
     * @param \Amasty\Shopby\Helper\Data                      $helper
     * @param \Magento\Framework\Controller\Result\RawFactory $resultRawFactory
     */
    public function __construct(
        \Amasty\Shopby\Helper\Data $helper,
        \Amasty\Shopby\Helper\UrlBuilder $urlBuilder,
        \Magento\Framework\Controller\Result\RawFactory $resultRawFactory
    ) {
        $this->helper = $helper;
        $this->resultRawFactory = $resultRawFactory;
        $this->urlBuilder = $urlBuilder;
    }

    /**
     * @param $controller
     *
     * @return bool
     */
    protected function isAjax($controller)
    {
        $isAjax = $controller->getRequest()->isAjax();
        $isScroll = $controller->getRequest()->getParam('is_scroll');
        return $this->helper->isAjaxEnabled() && $isAjax && !$isScroll;
    }

    /**
     * @param \Magento\Framework\View\Result\Page $page
     *
     * @return array
     */
    protected function getAjaxResponseData(\Magento\Framework\View\Result\Page $page)
    {
        $products = $page->getLayout()->getBlock('category.products');
        $navigation = $page->getLayout()->getBlock('catalog.leftnav');
        $applyButton = $page->getLayout()->getBlock('amasty.shopby.applybutton.sidebar');

        $navigationTop = $page->getLayout()->getBlock('amshopby.catalog.topnav');
        $applyButtonTop = $page->getLayout()->getBlock('amasty.shopby.applybutton.topnav');
        $h1 = $page->getLayout()->getBlock('page.main.title');
        $title = $page->getConfig()->getTitle();
        $breadcrumbs = $page->getLayout()->getBlock('breadcrumbs');

        $htmlCategoryData = '';
        $children = $page->getLayout()->getChildNames('category.view.container');
        foreach ($children as $child) {
            $htmlCategoryData .= $page->getLayout()->renderElement($child);
        }
        $htmlCategoryData = '<div class="category-view">' . $htmlCategoryData . '</div>';

        $shopbyCollapse = $page->getLayout()->getBlock('catalog.navigation.collapsing');
        $shopbyCollapseHtml = '';
        if($shopbyCollapse) {
            $shopbyCollapseHtml = $shopbyCollapse->toHtml();
        }

        $responseData = [
            'categoryProducts'=>$products->toHtml(),
            'navigation' => ($navigation ? $navigation->toHtml() : '') . $shopbyCollapseHtml . ($applyButton ? $applyButton->toHtml() : ''),
            'navigationTop' => ($navigationTop ? $navigationTop->toHtml() : '') . ($applyButtonTop ? $applyButtonTop->toHtml() : ''),
            'breadcrumbs' => $breadcrumbs ? $breadcrumbs->toHtml() : '',
            'h1' => $h1 ? $h1->toHtml() : '',
            'title' => $title->get(),
            'categoryData' => $htmlCategoryData,
            'url' => $this->urlBuilder->getUrl('*/*/*', ['_current' => true])
        ];

        return $responseData;
    }

    /**
     * @param array $data
     *
     * @return \Magento\Framework\Controller\Result\Raw
     */
    protected function prepareResponse(array $data)
    {
        $response = $this->resultRawFactory->create();
        $response->setHeader('Content-type', 'text/plain');
        $response->setContents(json_encode($data));
        return $response;
    }
}
