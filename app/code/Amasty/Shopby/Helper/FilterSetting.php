<?php
/**
 * @author Amasty Team
 * @copyright Copyright (c) 2016 Amasty (https://www.amasty.com)
 * @package Amasty_Shopby
 */


namespace Amasty\Shopby\Helper;

use Magento\Catalog\Model\Layer\Filter\FilterInterface;
use Magento\Framework\App\Helper\Context;
use Amasty\Shopby;
use Amasty\Shopby\Model\ResourceModel\FilterSetting\Collection;
use Amasty\Shopby\Model\ResourceModel\FilterSetting\CollectionFactory;
use Amasty\Shopby\Api\Data\FilterSettingInterface;

class FilterSetting extends \Magento\Framework\App\Helper\AbstractHelper
{
    const ATTR_PREFIX = 'attr_';
    /** @var  Collection */
    protected $collection;

    /** @var  Shopby\Model\FilterSettingFactory */
    protected $settingFactory;

    public function __construct(Context $context, CollectionFactory $settingCollectionFactory, Shopby\Model\FilterSettingFactory $settingFactory)
    {
        parent::__construct($context);
        $this->collection = $settingCollectionFactory->create();
        $this->settingFactory = $settingFactory;
    }

    /**
     * @param FilterInterface $layerFilter
     * @return Shopby\Api\Data\FilterSettingInterface
     */
    public function getSettingByLayerFilter(FilterInterface $layerFilter)
    {
        $filterCode = $this->getFilterCode($layerFilter);

        $setting = null;
        if (isset($filterCode)) {
            $setting = $this->collection->getItemByColumnValue(Shopby\Model\FilterSetting::FILTER_CODE, $filterCode);
        }
        if (is_null($setting)) {
            $data = [FilterSettingInterface::FILTER_CODE=>$filterCode];
            if($layerFilter instanceof \Amasty\Shopby\Model\Layer\Filter\Stock) {
                $data = $this->getDataByCustomFilter('stock');
            } elseif($layerFilter instanceof \Amasty\Shopby\Model\Layer\Filter\Rating) {
                $data = $this->getDataByCustomFilter('rating');
            } elseif($layerFilter instanceof \Amasty\Shopby\Model\Layer\Filter\IsNew) {
                $data = $this->getDataByCustomFilter('is_new');
            }elseif($layerFilter instanceof \Amasty\Shopby\Model\Layer\Filter\OnSale) {
                $data = $this->getDataByCustomFilter('on_sale');
            }
            $setting = $this->settingFactory->create(['data'=>$data]);
        }

        if($layerFilter instanceof \Amasty\Shopby\Model\Layer\Filter\Category) {
            $setting->addData($this->getCustomDataForCategoryFilter());
        }

        $setting->setAttributeModel($layerFilter->getData('attribute_model'));

        return $setting;
    }

    /**
     * @param $attributeModel
     *
     * @return \Amasty\Shopby\Api\Data\FilterSettingInterface
     */
    public function getSettingByAttribute($attributeModel)
    {
        return $this->getSettingByAttributeCode($attributeModel->getAttributeCode());
    }

    /**
     * @param $attributeCode
     *
     * @return \Amasty\Shopby\Api\Data\FilterSettingInterface
     */
    public function getSettingByAttributeCode($attributeCode)
    {
        $filterCode = self::ATTR_PREFIX . $attributeCode;
        $setting = $this->collection->getItemByColumnValue(Shopby\Model\FilterSetting::FILTER_CODE, $filterCode);
        if (is_null($setting)) {
            $data = [FilterSettingInterface::FILTER_CODE=>$filterCode];
            $setting = $this->settingFactory->create(['data'=>$data]);
        }

        if($attributeCode == \Amasty\Shopby\Helper\Category::ATTRIBUTE_CODE) {
            $setting->addData($this->getCustomDataForCategoryFilter());
        }

        return $setting;
    }

    protected function getFilterCode(FilterInterface $layerFilter)
    {
        if($layerFilter instanceof \Amasty\Shopby\Model\Layer\Filter\Category) {
            return self::ATTR_PREFIX . \Amasty\Shopby\Helper\Category::ATTRIBUTE_CODE;
        }
        try
        {
            // Produces exception when attribute model missing
            $attribute = $layerFilter->getAttributeModel();
            return self::ATTR_PREFIX . $attribute->getAttributeCode();
        } catch (\Exception $exception)
        {
            // Put here cases for special filters like Category, Stock etc.
            ;
        }

        return null;
    }

    protected function getDataByCustomFilter($filterName)
    {
        $data = [];
        $data[FilterSettingInterface::FILTER_SETTING_ID] = $filterName;
        $data[FilterSettingInterface::DISPLAY_MODE] = $this->scopeConfig->getValue('amshopby/'.$filterName.'_filter/display_mode', \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
        $data[FilterSettingInterface::FILTER_CODE] = $filterName;
        $data[FilterSettingInterface::IS_EXPANDED] = $this->scopeConfig->getValue('amshopby/'.$filterName.'_filter/is_expanded', \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
        $data[FilterSettingInterface::TOOLTIP] = $this->scopeConfig->getValue('amshopby/'.$filterName.'_filter/tooltip', \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
        $data[FilterSettingInterface::BLOCK_POSITION] = $this->scopeConfig->getValue('amshopby/'.$filterName.'_filter/block_position', \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
        return $data;
    }

    public function getCustomDataForCategoryFilter()
    {
        $data = [];
        foreach($this->getKeyValueForCategoryFilterConfig() as $key=>$value) {
            $data[$key] = $this->scopeConfig->getValue($value, \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
        }
        return $data;
    }

    public function getKeyValueForCategoryFilterConfig()
    {
        return [
            'category_tree_depth'           => 'amshopby/category_filter/category_tree_depth',
            'subcategories_view'            => 'amshopby/category_filter/subcategories_view',
            'subcategories_expand'          => 'amshopby/category_filter/subcategories_expand',
            'render_all_categories_tree'    => 'amshopby/category_filter/render_all_categories_tree',
            'render_categories_level'       => 'amshopby/category_filter/render_categories_level',
        ];
    }
}
