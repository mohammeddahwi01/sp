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

class Category extends Template
{
    /**
     * @var Collection
     */
    protected $collectionCategory;

    /**
     * Category constructor.
     * @param Template\Context $context
     * @param Collection $collectionCategory
     * @param array $data
     */
    public function __construct
    (
        Template\Context $context,
        Collection $collectionCategory,
        array $data = []
    )
    {
        parent::__construct($context, $data);

        $this->collectionCategory = $collectionCategory;
    }

    /**
     * @return Collection
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getCategories()
    {
        $collection = $this->collectionCategory;

        $collection
            ->addAttributeToSelect('*')
            ->addAttributeToFilter('parent_id', 2)
            ->addIsActiveFilter();

        return $collection;
    }
}