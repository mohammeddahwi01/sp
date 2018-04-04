<?php

namespace Eleanorsoft\ProductBlock\Block;

use Magento\Catalog\Model\Category;
use Magento\CatalogWidget\Model\Rule;
use Magento\Widget\Helper\Conditions;
use Magento\CatalogInventory\Helper\Stock;
use Magento\Catalog\Model\CategoryFactory;
use Magento\Catalog\Model\Product\Visibility;
use Magento\Rule\Model\Condition\Sql\Builder;
use Magento\CatalogWidget\Block\Product\ProductsList;
use Magento\Framework\App\Http\Context as HttpContext;
use Magento\Catalog\Model\Product\Attribute\Source\Status;
use Magento\Catalog\Block\Product\Context as ProductContext;
use Magento\Catalog\Model\ResourceModel\Product\Collection as ProductCollection;
use Magento\Catalog\Model\ResourceModel\Product\CollectionFactory as ProductCollectionFactory;

/**
 * Class ProductList
 * Block which gets products for specified category.
 *
 * @package Eleanorsoft\ProductBlock\Block
 * @author Eugene Polischuk <eugene.polischuk@eleanorsoft.com>
 * @copyright Copyright (c) 2018 Eleanorsoft (https://www.eleanorsoft.com/)
 */
class ProductList extends ProductsList
{

    protected $_isScopePrivate = true;

    /**
     * @var Stock
     */
    protected $stock;

    /**
     * @var Category
     */
    protected $category;

    /**
     * @var CategoryFactory
     */
    protected $categoryFactory;

    /**
     * @var ProductCollection
     */
    protected $productCollection;

    /**
     * ProductList constructor.
     *
     * @param Rule $rule
     * @param Stock $stock
     * @param Builder $sqlBuilder
     * @param ProductContext $context
     * @param HttpContext $httpContext
     * @param Conditions $conditionsHelper
     * @param CategoryFactory $categoryFactory
     * @param Visibility $catalogProductVisibility
     * @param ProductCollectionFactory $productCollectionFactory
     * @param array $data
     * @author Eugene Polischuk <eugene.polischuk@eleanorsoft.com>
     */
    public function __construct(
        Rule $rule,
        Stock $stock,
        Builder $sqlBuilder,
        ProductContext $context,
        HttpContext $httpContext,
        Conditions $conditionsHelper,
        CategoryFactory $categoryFactory,
        Visibility $catalogProductVisibility,
        ProductCollectionFactory $productCollectionFactory,
        array $data = []
    ) {
        $this->stock = $stock;
        $this->categoryFactory = $categoryFactory;

        parent::__construct(
            $context,
            $productCollectionFactory,
            $catalogProductVisibility,
            $httpContext,
            $sqlBuilder,
            $rule,
            $conditionsHelper,
            $data
        );
    }

    /**
     * Get category id.
     *
     * @return int
     * @author Eugene Polischuk <eugene.polischuk@eleanorsoft.com>
     */
    public function getCategoryId()
    {
        return $this->getData('category_id');
    }

    /**
     * Set category id.
     *
     * @param int $categoryId
     * @author Eugene Polischuk <eugene.polischuk@eleanorsoft.com>
     */
    public function setCategoryId($categoryId)
    {
        $this->setData('category_id', $categoryId);
    }

    /**
     * Set products per page.
     *
     * @param int $productsPerPage
     * @author Eugene Polischuk <eugene.polischuk@eleanorsoft.com>
     */
    public function setProductsPerPage($productsPerPage)
    {
        $this->setData('products_per_page', $productsPerPage);
    }

    /**
     * Get product category.
     *
     * @return Category
     * @author Eugene Polischuk <eugene.polischuk@eleanorsoft.com>
     */
    public function getCategory()
    {
        if (!$this->category) {
            $this->category = $this->categoryFactory->create()
                ->load($this->getCategoryId());
        }

        return $this->category;
    }

    /**
     * Get product collection.
     *
     * @return ProductCollection
     * @author Eugene Polischuk <eugene.polischuk@eleanorsoft.com>
     */
    public function getProductCollection()
    {
        if (!$this->productCollection) {
            $this->productCollection = $this->productCollectionFactory->create();

            $this->productCollection
                ->addAttributeToSelect('*')
                ->addCategoryFilter($this->getCategory())
                ->addAttributeToFilter('status', ['eq' => Status::STATUS_ENABLED])
                ->setVisibility($this->catalogProductVisibility->getVisibleInCatalogIds())
                ->addAttributeToSort('position')
                ->setPageSize($this->getProductsPerPage());

            $this->stock->addInStockFilterToCollection($this->productCollection);
        }

        return $this->productCollection;
    }
}
