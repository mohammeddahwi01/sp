<?php
/**
 * @author Amasty Team
 * @copyright Copyright (c) 2016 Amasty (https://www.amasty.com)
 * @package Amasty_Shopby
 */
namespace Amasty\Shopby\Block\Navigation;

use Amasty\Shopby\Api\Data\FilterSettingInterface;
use Amasty\Shopby\Helper\FilterSetting;
use Amasty\Shopby\Helper\Data as ShopbyHelper;
use Amasty\Shopby\Helper\UrlBuilder;
use Amasty\Shopby\Model\Layer\Filter\Item;
use Amasty\Shopby\Model\Source\DisplayMode;
use Magento\Catalog\Model\Layer\Filter\FilterInterface;

class FilterRenderer extends \Magento\LayeredNavigation\Block\Navigation\FilterRenderer
    implements RendererInterface
{
    /** @var  FilterSetting */
    protected $settingHelper;

    /** @var  UrlBuilder */
    protected $urlBuilder;

    /** @var  FilterInterface */
    protected $filter;

    /**
     * @var ShopbyHelper
     */
    protected $helper;

    /**
     * @var \Amasty\Shopby\Helper\Category
     */
    protected $categoryHelper;

    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        FilterSetting $settingHelper,
        UrlBuilder $urlBuilder,
        ShopbyHelper $helper,
        \Amasty\Shopby\Helper\Category $categoryHelper,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->settingHelper = $settingHelper;
        $this->urlBuilder = $urlBuilder;
        $this->helper = $helper;
        $this->categoryHelper = $categoryHelper;
    }

    public function render(FilterInterface $filter)
    {
        $this->filter = $filter;
        $setting = $this->settingHelper->getSettingByLayerFilter($filter);

        if($filter instanceof \Amasty\Shopby\Model\Layer\Filter\Category && $this->categoryHelper->isCategoryFilterExtended()) {
            $template = $this->getCustomTemplateForCategoryFilter($setting);
        } else {
            $template = $this->getTemplateByFilterSetting($setting);
        }

        $this->setTemplate($template);
        $this->assign('filterSetting', $setting);
        $this->assign('tooltipUrl', $this->helper->getTooltipUrl());

        if ($this->filter instanceof \Amasty\Shopby\Api\Data\FromToFilterInterface)
        {
            $fromToConfig = $this->filter->getFromToConfig();
            $this->assign('fromToConfig', $fromToConfig);
        }

        return parent::render($filter);
    }

    protected function getTemplateByFilterSetting(FilterSettingInterface $filterSetting)
    {
        switch($filterSetting->getDisplayMode()) {
            case DisplayMode::MODE_SLIDER:
                $template = "layer/filter/slider.phtml";
                break;
            case DisplayMode::MODE_DROPDOWN:
                $template = "layer/filter/dropdown.phtml";
                break;
            case DisplayMode::MODE_FROM_TO_ONLY:
                $template = "layer/filter/fromto.phtml";
                break;
            default:
                $template = "layer/filter/default.phtml";
                break;
        }
        return $template;
    }

    protected function getCustomTemplateForCategoryFilter(FilterSettingInterface $filterSetting)
    {
        switch($filterSetting->getDisplayMode()) {
            case DisplayMode::MODE_DROPDOWN:
                $template = "layer/filter/category/dropdown.phtml";
                break;
            default:
                if($filterSetting->getSubcategoriesView() == \Amasty\Shopby\Model\Source\SubcategoriesView::FOLDING) {
                    $template = 'layer/filter/category/labels_folding.phtml';
                } else {
                    $template = 'layer/filter/category/labels_fly_out.phtml';
                }
                break;
        }
        return $template;
    }

    public function checkedFilter($filterItem)
    {
        return $this->helper->isFilterItemSelected($filterItem);
    }

    public function getClearUrl()
    {
        if (!array_key_exists('filterItems', $this->_viewVars) || !is_array($this->_viewVars['filterItems'])) {
            return '';
        }
        $items = $this->_viewVars['filterItems'];

        foreach ($items as $item) {
            /** @var Item $item */

            if ($this->checkedFilter($item)) {
                return $item->getRemoveUrl();
            }
        }

        return '';
    }

    public function getSliderUrlTemplate()
    {
        return $this->urlBuilder->buildUrl($this->filter, 'amshopby_slider_from-amshopby_slider_to');
    }

    public function escapeId($data)
    {
        return str_replace(",", "_", $data);
    }

    /**
     * @return string
     */
    public function collectFilters()
    {
        return $this->_scopeConfig->getValue(self::XML_CONFIG_SUBMIT_FILTER) === \Amasty\Shopby\Model\Source\SubmitMode::BY_BUTTON_CLICK ? '1' : '0';
    }

    public function getFilter()
    {
        return $this->filter;
    }
}
