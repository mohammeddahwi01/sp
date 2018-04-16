<?php
/**
 * Created by PhpStorm.
 * User: denis
 * Date: 13.04.18
 * Time: 15:51
 */

namespace Eleanorsoft\Category\Block;

use Magento\Catalog\Model\ResourceModel\Category\Collection;
use Magento\Framework\View\Element\Template;
use Magento\Store\Model\StoreManagerInterface;

/**
 * Class Category
 * todo: What is its purpose? What does it do?
 *
 * Usage example:
 *      <block class="Eleanorsoft\Category\Block\Category" name="es_category" template="Eleanorsoft_Category::category.phtml"/> - layout
 *      {{block class="Eleanorsoft\Category\Block\Category" template="Eleanorsoft_Category::category.phtml"}}                   - CMS page
 *
 * @package Eleanorsoft_
 * @author Pisarenko Denis <denis.pisarenko@eleanorsoft.com>
 * @copyright Copyright (c) 2018 Eleanorsoft (https://www.eleanorsoft.com/)
 */
class Category extends Template
{
    /**
     * @var Collection
     */
    protected $collectionCategory;

    /**
     * @var StoreManagerInterface
     */
    protected $storeManager;

    /**
     * Category constructor.
     * @param Template\Context $context
     * @param Collection $collectionCategory
     * @param StoreManagerInterface $storeManager
     * @param array $data
     */
    public function __construct
    (
        Template\Context $context,
        Collection $collectionCategory,
        StoreManagerInterface $storeManager,
        array $data = []
    )
    {
        parent::__construct($context, $data);
        $this->collectionCategory = $collectionCategory;
        $this->storeManager = $storeManager;
    }

    /**
     * Returns the children of the main category
     *
     * @return Collection
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getCategories()
    {
        $collection = $this->collectionCategory;
        $root_category_id = (int)$this->storeManager->getStore()->getRootCategoryId();
        $collection
            ->addAttributeToSelect('*')
            ->addAttributeToFilter('parent_id', $root_category_id)
            ->addIsActiveFilter();

        return $collection;
    }
}