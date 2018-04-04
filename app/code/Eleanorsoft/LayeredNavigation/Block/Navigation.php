<?php

namespace Eleanorsoft\LayeredNavigation\Block;

use Magento\Catalog\Model\Layer;
use Magento\Catalog\Model\Layer\FilterList;
use Magento\Catalog\Model\Layer\Filter\AbstractFilter;
use Magento\LayeredNavigation\Block\Navigation as BaseBlock;
use Eleanorsoft\LayeredNavigation\Model\CatalogSearchLayerFilterAttribute;

/**
 * Class Navigation
 * Block with additional temporary layer.
 * It's for keeping all filters in clean state,
 * with clean product collection for each filter.
 *
 * @package Eleanorsoft\LayeredNavigation\Block
 * @author Eugene Polischuk <eugene.polischuk@eleanorsoft.com>
 * @copyright Copyright (c) 2017 Eleanorsoft (https://www.eleanorsoft.com/)
 */
class Navigation extends BaseBlock
{
    /**
     * @var array
     */
    protected $allowedFilterTypes = ['price'];

    /**
     * Pseudo construct.
     *
     * @author Eugene Polischuk <eugene.polischuk@eleanorsoft.com>
     */
    public function _construct()
    {
        $this->setTempLayer(clone $this->getLayer());
        $this->setTempFilterList(clone $this->filterList);

        parent::_construct();
    }

    /**
     * Get temporary layer.
     *
     * @return Layer
     * @author Eugene Polischuk <eugene.polischuk@eleanorsoft.com>
     */
    public function getTempLayer()
    {
        return $this->getData('temp_layer');
    }

    /**
     * Set temporary layer.
     *
     * @var Layer $layer
     * @author Eugene Polischuk <eugene.polischuk@eleanorsoft.com>
     */
    public function setTempLayer($layer)
    {
        $this->setData('temp_layer', $layer);
    }

    /**
     * Get temporary filter list.
     *
     * @return FilterList
     * @author Eugene Polischuk <eugene.polischuk@eleanorsoft.com>
     */
    public function getTempFilterList()
    {
        return $this->getData('temp_filter_list');
    }

    /**
     * Set temporary filter list.
     *
     * @param FilterList $filterList
     * @author Eugene Polischuk <eugene.polischuk@eleanorsoft.com>
     */
    public function setTempFilterList($filterList)
    {
        $this->setData('temp_filter_list', $filterList);
    }

    /**
     * Get temporary layer filters;
     *
     * @return array|AbstractFilter[]
     * @author Eugene Polischuk <eugene.polischuk@eleanorsoft.com>
     */
    public function getTempLayerFilters()
    {
        return $this->getTempFilterList()->getFilters($this->getTempLayer());
    }

    /**
     * Get specific filter html.
     *
     * @param AbstractFilter $filter
     * @return string
     * @author Eugene Polischuk <eugene.polischuk@eleanorsoft.com>
     */
    public function getFilterHtml($filter)
    {
        if (in_array($filter->getRequestVar(), $this->allowedFilterTypes)) {
            $renderer = $this->getData($filter->getRequestVar() . '_renderer');
        } else {
            $renderer = $this->getData('renderer');
        }

        return $renderer->render($filter);
    }

    /**
     * Setup all filter blocks.
     *
     * @author Eugene Polischuk <eugene.polischuk@eleanorsoft.com>
     */
    protected function setupFilterBlocks()
    {
        $this->setData('renderer', $this->getChildBlock('renderer'));

        foreach ($this->allowedFilterTypes as $filterType) {
            $filterName = $filterType . '_renderer';
            $this->setData($filterName, $this->getChildBlock($filterName));
        }
    }

    /**
     * @return $this
     * @author Eugene Polischuk <eugene.polischuk@eleanorsoft.com>
     */
    protected function _prepareLayout()
    {
        $this->setupTempLayer();
        $this->setupFilterBlocks();

        return parent::_prepareLayout();
    }

    /**
     * Setup temporary layer.
     *
     * @author Eugene Polischuk <eugene.polischuk@eleanorsoft.com>
     */
    protected function setupTempLayer()
    {
        foreach ($this->getTempLayerFilters() as $filter) {
            if ($filter instanceof CatalogSearchLayerFilterAttribute) {
                /** @var CatalogSearchLayerFilterAttribute $filter */
                $filter->setTempLayer($this->getTempLayer());
                $filter->apply($this->getRequest());
            }
        }

        $this->getTempLayer()->apply();
    }
}
