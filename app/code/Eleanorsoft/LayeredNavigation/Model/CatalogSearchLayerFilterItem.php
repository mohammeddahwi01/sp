<?php

namespace Eleanorsoft\LayeredNavigation\Model;

use Magento\Catalog\Model\Layer\Filter\Item as FilterItem;

/**
 * Class CatalogSearchLayerFilterItem
 * Preference class for FilterItem,
 * which adds logic to get url.
 *
 * @package Eleanorsoft\LayeredNavigation\Model
 * @author Eugene Polischuk <eugene.polischuk@eleanorsoft.com>
 * @copyright Copyright (c) 2017 Eleanorsoft (https://www.eleanorsoft.com/)
 */
class CatalogSearchLayerFilterItem extends FilterItem
{
    /**
     * @var \Magento\Framework\App\RequestInterface
     */
    protected $request;

    /**
     * CatalogSearchLayerFilterItem constructor.
     *
     * @param \Magento\Framework\UrlInterface $url
     * @param \Magento\Theme\Block\Html\Pager $htmlPagerBlock
     * @param \Magento\Framework\App\RequestInterface $request
     * @param array $data
     * @author Eugene Polischuk <eugene.polischuk@eleanorsoft.com>
     */
    public function __construct(
        \Magento\Framework\UrlInterface $url,
        \Magento\Theme\Block\Html\Pager $htmlPagerBlock,
        \Magento\Framework\App\RequestInterface $request,
        array $data = []
    ) {
        $this->request = $request;

        parent::__construct(
            $url,
            $htmlPagerBlock,
            $data
        );
    }

    /**
     * Get filter item url.
     *
     * @return string
     * @author Eugene Polischuk <eugene.polischuk@eleanorsoft.com>
     */
    public function getUrl()
    {
        if ($this->getFilter()->getRequestVar() == 'price') {
            return parent::getUrl();
        }

        return $this->_url->getUrl('*/*/*', [
            '_current' => true,
            '_use_rewrite' => true,
            '_query' => [
                $this->getFilter()->getRequestVar().'[]' => $this->getValue(),
                $this->_htmlPagerBlock->getPageVarName() => null,
            ]
        ]);
    }

    /**
     * Get url for remove item from filter.
     *
     * @return string
     * @author Eugene Polischuk <eugene.polischuk@eleanorsoft.com>
     */
    public function getRemoveUrl()
    {
        if ($this->getFilter()->getRequestVar() == 'price') {
            return parent::getRemoveUrl();
        }

        $currentFilterParams = array_diff(
            $this->request->getParam($this->getFilter()->getRequestVar()),
            [$this->getValueString()]
        );

        return $this->_url->getUrl('*/*/*', [
            '_current' => true,
            '_use_rewrite' => true,
            '_query' => [$this->getFilter()->getRequestVar() => $currentFilterParams],
            '_escape' => true
        ]);
    }
}
