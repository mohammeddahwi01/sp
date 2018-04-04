<?php

namespace Eleanorsoft\LayeredNavigation\Block\Navigation;

use Magento\Catalog\Model\Layer\Filter\FilterInterface;
use Magento\Catalog\Model\Layer\Filter\Item as FilterItem;

/**
 * Class PriceFilterRenderer
 * Price filter renderer class.
 *
 * @package Eleanorsoft\LayeredNavigation\Block\Navigation
 * @author Eugene Polischuk <eugene.polischuk@eleanorsoft.com>
 * @copyright Copyright (c) 2017 Eleanorsoft (https://www.eleanorsoft.com/)
 */
class PriceFilterRenderer extends FilterRenderer
{
    /**
     * Get price filter item.
     *
     * @return FilterItem
     * @author Eugene Polischuk <eugene.polischuk@eleanorsoft.com>
     */
    public function getPriceFilterItem()
    {
        return $this->getData('priceFilterItem');
    }

    /**
     * Get currency symbol.
     *
     * @return string
     * @author Eugene Polischuk <eugene.polischuk@eleanorsoft.com>
     */
    public function getCurrencySymbol()
    {
        return $this->getData('currencySymbol');
    }

    /**
     * Get static price ranges.
     *
     * @return array
     * @author Eugene Polischuk <eugene.polischuk@eleanorsoft.com>
     */
    public function getPriceRanges()
    {
        return [
            '0-20',
            '20-40',
            '40-60',
            '60-80',
            '80-100',
            '100-'
        ];
    }

    /**
     * @param FilterInterface $filter
     * @return string
     * @author Eugene Polischuk <eugene.polischuk@eleanorsoft.com>
     */
    public function render(FilterInterface $filter)
    {
        $this->setData('priceFilterItem', $filter->getItems()[0]);

        $priceFilterItemPriceArgument = strip_tags(
            $this->getPriceFilterItem()->getLabel()->getArguments()[0]
        );

        $this->setData('currencySymbol', $priceFilterItemPriceArgument[0]);

        return parent::render($filter);
    }
}
