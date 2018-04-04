<?php

namespace Eleanorsoft\LayeredNavigation\Block\Navigation;

use Magento\Framework\View\Element\Template\Context;
use Magento\Framework\App\Request\Http as RequestHttp;
use Magento\Catalog\Model\Layer\Filter\FilterInterface;
use Magento\Catalog\Model\Layer\Filter\Item as FilterItem;
use Magento\LayeredNavigation\Block\Navigation\FilterRenderer as BaseBlock;

/**
 * Class FilterRenderer
 * Preference class with additional logic.
 *
 * @package Eleanorsoft\LayeredNavigation\Block\Navigation
 * @author Eugene Polischuk <eugene.polischuk@eleanorsoft.com>
 * @copyright Copyright (c) 2017 Eleanorsoft (https://www.eleanorsoft.com/)
 */
class FilterRenderer extends BaseBlock
{
    /**
     * @var FilterItem
     */
    private $filter;

    /**
     * @var array
     */
    private $activeFilterItemValues;

    /**
     * @var RequestHttp
     */
    protected $_request;

    /**
     * FilterRenderer constructor.
     *
     * @param RequestHttp $request
     * @param Context $context
     * @author Eugene Polischuk <eugene.polischuk@eleanorsoft.com>
     */
    public function __construct(
        RequestHttp $request,
        Context $context
    ) {
        $this->_request = $request;

        parent::__construct($context);
    }

    /**
     * Get filter.
     *
     * @return FilterItem
     * @author Eugene Polischuk <eugene.polischuk@eleanorsoft.com>
     */
    public function getFilter()
    {
        return $this->filter;
    }

    /**
     * @return FilterItem[]
     * @author Eugene Polischuk <eugene.polischuk@eleanorsoft.com>
     */
    public function getFilterItems()
    {
        return $this->getData('filterItems');
    }

    /**
     * Get active filter item value.
     *
     * @return mixed
     * @author Eugene Polischuk <eugene.polischuk@eleanorsoft.com>
     */
    public function getActiveFilterItemValues()
    {
        return $this->activeFilterItemValues;
    }

    /**
     * Check if filter item is active.
     *
     * @param $filterItem
     * @return bool
     * @author Eugene Polischuk <eugene.polischuk@eleanorsoft.com>
     */
    public function isFilterItemActive($filterItem)
    {
        return in_array($filterItem->getValue(), $this->getActiveFilterItemValues());
    }

    /**
     * Check if specified filter value is active.
     *
     * @param $filterCode
     * @param $filterValue
     * @return bool
     * @author Eugene Polischuk <eugene.polischuk@eleanorsoft.com>
     */
    public function isFilterValueActive($filterCode, $filterValue)
    {
        return in_array($filterValue, $this->getQueryFilterItemValues($filterCode));
    }

    /**
     * Prepare config data from filter object.
     *
     * @param FilterInterface $filter
     * @author Eugene Polischuk <eugene.polischuk@eleanorsoft.com>
     */
    public function prepareFromFilter($filter)
    {
        $this->setFilter($filter);

        $filterCode = $this->getFilter()->getRequestVar();

        $this->setActiveFilterItemValues($this->getQueryFilterItemValues($filterCode));
    }

    /**
     * @param FilterInterface $filter
     * @return string
     */
    public function render(FilterInterface $filter)
    {
        $this->prepareFromFilter($filter);

        $this->setData('filterItems', $filter->getItems());

        $html = parent::render($filter);

        $this->unsetData('filterItems');

        return $html;
    }

    /**
     * Set filter.
     *
     * @param FilterInterface $filter
     * @author Eugene Polischuk <eugene.polischuk@eleanorsoft.com>
     */
    protected function setFilter($filter)
    {
        $this->filter = $filter;
    }

    /**
     * Set active filter item value.
     *
     * @param mixed $activeFilterItemValues
     * @author Eugene Polischuk <eugene.polischuk@eleanorsoft.com>
     */
    protected function setActiveFilterItemValues($activeFilterItemValues)
    {
        $this->activeFilterItemValues = $activeFilterItemValues;
    }

    /**
     * Get active filter item value from http get request.
     *
     * @param null $filterCode
     * @return array|mixed
     * @author Eugene Polischuk <eugene.polischuk@eleanorsoft.com>
     */
    protected function getQueryFilterItemValues($filterCode)
    {
        $queryParams = $this->_request->getQueryValue();
        $values = array_key_exists($filterCode, $queryParams) ? $queryParams[$filterCode] : [];

        return is_array($values) ? $values : [$values];
    }
}
