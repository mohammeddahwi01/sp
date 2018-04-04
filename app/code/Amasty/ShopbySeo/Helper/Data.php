<?php
/**
 * @author Amasty Team
 * @copyright Copyright (c) 2016 Amasty (https://www.amasty.com)
 * @package Amasty_Shopby
 */


namespace Amasty\ShopbySeo\Helper;


use Amasty\Shopby\Api\Data\FilterSettingInterface;
use Amasty\Shopby\Model\Cache\Type;
use Magento\Eav\Model\ResourceModel\Entity\Attribute\Option;
use Magento\Framework\App\Cache;
use Magento\Framework\App\Helper\Context;
use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Store\Model\StoreManager;
use Amasty\Shopby\Model\ResourceModel\FilterSetting\CollectionFactory;
use Amasty\Shopby\Model\ResourceModel\OptionSetting\CollectionFactory as OptionSettingCollectionFactory;

class Data extends AbstractHelper
{
    const CANONICAL_ROOT = 'amasty_shopby_seo/canonical/root';
    const CANONICAL_CATEGORY = 'amasty_shopby_seo/canonical/category';

    /** @var CollectionFactory */
    protected $settingCollectionFactory;
    /** @var Option\CollectionFactory */
    protected $optionCollectionFactory;
    /** @var  OptionSettingCollectionFactory */
    protected $optionSettingCollectionFactory;
    /** @var  StoreManager */
    protected $storeManager;

    /** @var  \Magento\Catalog\Model\Product\Url */
    protected $productUrl;

    /** @var  Type */
    protected $cache;

    /** @var  Cache\StateInterface */
    protected $cacheState;

    protected $seoSignificantUrlParameters;
    protected $optionsSeoData;

    public function __construct(
        Context $context,
        CollectionFactory $settingCollectionFactory,
        Option\CollectionFactory $optionCollectionFactory,
        \Magento\Catalog\Model\Product\Url $productUrl,
        OptionSettingCollectionFactory $optionSettingCollectionFactory,
        StoreManager $storeManager,
        Cache $cache,
        Cache\StateInterface $cacheState
    )
    {
        parent::__construct($context);
        $this->settingCollectionFactory = $settingCollectionFactory;
        $this->optionCollectionFactory = $optionCollectionFactory;
        $this->optionSettingCollectionFactory = $optionSettingCollectionFactory;
        $this->storeManager = $storeManager;
        $this->productUrl = $productUrl;
        $this->cache = $cache;
        $this->cacheState = $cacheState;
    }

    public function getSeoSignificantUrlParameters()
    {
        if (is_null($this->seoSignificantUrlParameters)) {
            $this->seoSignificantUrlParameters = $this->getSeoSignificantAttributeCodes();
        }
        return $this->seoSignificantUrlParameters;
    }

    public function getOptionsSeoData()
    {
        $cache_id = 'amshopby_seo_options_data';
        if (is_null($this->optionsSeoData) && $this->cacheState->isEnabled(Type::TYPE_IDENTIFIER)) {
            $cached = $this->cache->load($cache_id);
            if ($cached !== false) {
                $this->optionsSeoData = unserialize($cached);
            }
        }
        if (is_null($this->optionsSeoData)) {
            $this->optionsSeoData = [];
            $aliasHash = [];

            $hardcodedAliases = $this->loadHardcodedAliases();
            foreach ($hardcodedAliases as $row) {
                $alias = $this->buildUniqueAlias($row['url_alias'], $aliasHash);
                if (strpos($row['filter_code'], 'attr_') === 0) {
                    $attributeCode = substr($row['filter_code'], strlen('attr_'));
                } else {
                    $attributeCode = '';
                }
                $this->optionsSeoData[$row['value']] = [
                    'alias' => $alias,
                    'attribute_code' => $attributeCode,
                ];
                $aliasHash[$alias] = $row['value'];
            }

            $dynamicAliases = $this->loadDynamicAliasesExcluding(array_values($aliasHash));
            foreach ($dynamicAliases as $row) {
                $alias = $this->buildUniqueAlias($row['value'], $aliasHash);
                $optionId = $row['option_id'];
                $this->optionsSeoData[$optionId] = [
                    'alias' => $alias,
                    'attribute_code' => $row['attribute_code'],
                ];
                $aliasHash[$alias] = $optionId;
            }
            if ($this->cacheState->isEnabled(Type::TYPE_IDENTIFIER)) {
                $this->cache->save(serialize($this->optionsSeoData), $cache_id, [Type::CACHE_TAG]);
            }
        }
        return $this->optionsSeoData;
    }

    protected function loadHardcodedAliases()
    {
        $select = $this->optionSettingCollectionFactory->create()->getSelect();
        $storeId = $this->storeManager->getStore()->getId();
        $listStores = '0';
        if($storeId > 0) {
            $listStores .= ',' . $storeId;
        }
        $select->reset(\Magento\Framework\DB\Select::COLUMNS);
        $select->columns('url_alias');
        $select->columns('filter_code');
        $select->columns('value');
        $select->where('`url_alias` <> ""');
        $select->where('`store_id` IN (' . $listStores . ')');
        $select->order('store_id ASC');
        $data = $select->getConnection()->fetchAll($select);
        return $data;
    }

    protected function loadDynamicAliasesExcluding($excludeOptionIds = array())
    {
        $seoAttributeCodes = $this->getSeoSignificantAttributeCodes();

        $collection = $this->optionCollectionFactory->create();
        $collection->join(['a' => 'eav_attribute'], 'a.attribute_id = main_table.attribute_id', ['attribute_code']);
        $collection->addFieldToFilter('attribute_code', ['in' => $seoAttributeCodes]);
        $collection->setStoreFilter();
        $select = $collection->getSelect();
        if ($excludeOptionIds) {
            $select->where('`main_table`.`option_id` NOT IN (' . join(',', $excludeOptionIds) . ')');
        }
        $statement = $select->query();
        $rows = $statement->fetchAll();
        return $rows;
    }

    protected function getSeoSignificantAttributeCodes()
    {
        $collection = $this->settingCollectionFactory->create();
        $collection->addFieldToFilter(FilterSettingInterface::IS_SEO_SIGNIFICANT, 1);
        $filterCodes = $collection->getColumnValues(FilterSettingInterface::FILTER_CODE);
        array_walk($filterCodes, function (&$code) {
            if (substr($code, 0, 5) == \Amasty\Shopby\Helper\FilterSetting::ATTR_PREFIX) {
                $code = substr($code, 5);
            }
        });
        return $filterCodes;
    }

    protected function buildUniqueAlias($value, $hash)
    {
        if (preg_match('@^[\d\.]+$@s', $value)) {
            $format = $value;
        } else {
            $format = $this->productUrl->formatUrlKey($value);
        }
        if ($format == '') {
            // Magento formats '-' as ''
            $format = '-';
        }

        $unique = $format;
        for ($i=1; array_key_exists($unique, $hash); $i++) {
            $unique = $format . '-' . $i;
        }
        return $unique;
    }

    public function getCanonicalRoot()
    {
        return $this->scopeConfig->getValue(self::CANONICAL_ROOT);
    }

    public function getCanonicalCategory()
    {
        return $this->scopeConfig->getValue(self::CANONICAL_CATEGORY);
    }

    public function getGeneralUrl()
    {
        return $this->scopeConfig->getValue('amshopby_root/general/url');
    }

    public function getBrandAttributeCode()
    {
        return $this->scopeConfig->getValue('amshopby_brand/general/attribute_code');
    }

    public function getUrlBuilder()
    {
        return $this->_urlBuilder;
    }
}
