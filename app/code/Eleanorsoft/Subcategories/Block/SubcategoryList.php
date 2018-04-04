<?php

namespace Eleanorsoft\Subcategories\Block;

use \Magento\Framework\Registry;
use \Magento\Catalog\Model\Category;
use \Magento\Catalog\Block\Category\View;
use \Magento\Catalog\Model\Layer\Resolver;
use \Magento\Framework\View\Element\Template\Context;
use \Magento\Catalog\Helper\Category as CategoryHelper;
use \Magento\Catalog\Model\ResourceModel\Category\Collection;
use \Magento\Catalog\Model\ResourceModel\Category\CollectionFactory;

/**
 * Class SubcategoryList
 * CMS Block class for category view.
 *
 * @package Eleanorsoft\Subcategories\Block
 * @author Eugene Polischuk <eugene.polischuk@eleanorsoft.com>
 * @copyright Copyright (c) 2017 Eleanorsoft (https://www.eleanorsoft.com/)
 */
class SubcategoryList extends View
{
    /**
     * @var CollectionFactory
     */
    protected $categoryCollection;

    /**
     * SubcategoryList constructor.
     *
     * @param Context $context
     * @param Registry $registry
     * @param Resolver $layerResolver
     * @param CategoryHelper $categoryHelper
     * @param CollectionFactory $categoryCollection
     * @param array $data
     * @author Eugene Polischuk <eugene.polischuk@eleanorsoft.com>
     */
    public function __construct(
        Context $context,
        Registry $registry,
        Resolver $layerResolver,
        CategoryHelper $categoryHelper,
        CollectionFactory $categoryCollection,
        array $data = []
    ) {
        $this->categoryCollection = $categoryCollection;

        parent::__construct(
            $context,
            $layerResolver,
            $registry,
            $categoryHelper,
            $data
        );
    }

    /**
     * Get category collection model.
     *
     * @return Collection
     * @author Eugene Polischuk <eugene.polischuk@eleanorsoft.com>
     */
    public function getCategoryCollectionModel()
    {
        return $this->categoryCollection->create();
    }

    /**
     * Get hex color from category.
     *
     * @param Category $category
     * @return string
     * @author Eugene Polischuk <eugene.polischuk@eleanorsoft.com>
     */
    public function getCategoryColor($category)
    {
        $color = $category->getData('el_color_picker') ?: 'fff';

        return "#$color";
    }

    /**
     * Get current category children with all attributes.
     *
     * @return Category[]|Collection
     * @author Eugene Polischuk <eugene.polischuk@eleanorsoft.com>
     */
    public function getCurrentCategoryChildren()
    {
        $currentCategory = $this->getCurrentCategory();
        $collection = $this->getCategoryCollectionModel();

        return $collection->addAttributeToSelect('*')
            ->addAttributeToFilter('is_active', 1)
            ->setOrder('position', 'ASC')
            ->addIdFilter($currentCategory->getChildren());
    }
}
