<?php

namespace Eleanorsoft\ShopOtherCategories\Model;

use \Magento\Framework\DataObject;
use \Magento\Catalog\Model\Product\Link;
use \Magento\Catalog\Model\Product\LinkFactory;
use \Magento\Catalog\Model\ResourceModel\Product\Link\Product\Collection;

/**
 * Class UpSellProduct
 * Class for accessing to up-sell product collection.
 *
 * @package Eleanorsoft\ShopOtherCategories\Model
 * @author Eugene Polischuk <eugene.polischuk@eleanorsoft.com>
 * @copyright Copyright (c) 2017 Eleanorsoft (https://www.eleanorsoft.com/)
 */
class UpSellProduct extends DataObject
{
    /**
     * Product link model factory.
     *
     * @var LinkFactory
     */
    protected $productLink;

    /**
     * UpSellProduct constructor.
     *
     * @param LinkFactory $productLink
     * @param array $data
     * @author Eugene Polischuk <eugene.polischuk@eleanorsoft.com>
     */
    public function __construct(
        LinkFactory $productLink,
        array $data = []
    ) {
        $this->productLink = $productLink;

        parent::__construct($data);
    }

    /**
     * Product link model.
     *
     * @return Link
     * @author Eugene Polischuk <eugene.polischuk@eleanorsoft.com>
     */
    public function getProductLinkModel()
    {
        return $this->productLink->create();
    }

    /**
     * Get up-sell product collection.
     *
     * @return Collection
     * @author Eugene Polischuk <eugene.polischuk@eleanorsoft.com>
     */
    public function getUpSellProductCollection()
    {
        return $this->getProductLinkModel()
                ->useUpSellLinks()
                ->getProductCollection();
    }
}
