<?php

namespace Eleanorsoft\ShopOtherCategories\Model\Order;

use \Magento\Sales\Model\Order;
use \Magento\Framework\DataObject;
use \Magento\Catalog\Api\Data\ProductInterface;
use \Magento\Catalog\Api\Data\ProductAttributeInterface;
use \Eleanorsoft\ShopOtherCategories\Model\UpSellProduct;
use \Eleanorsoft\ShopOtherCategories\Model\UpSellProductFactory;
use \Magento\Catalog\Ui\DataProvider\Product\Form\Modifier\Images;
use \Magento\Catalog\Model\ResourceModel\Product\Link\Product\Collection;

/**
 * Class LinkedProduct
 * Order product link class.
 *
 * @package Eleanorsoft\ShopOtherCategories\Model\Order
 * @author Eugene Polischuk <eugene.polischuk@eleanorsoft.com>
 * @copyright Copyright (c) 2017 Eleanorsoft (https://www.eleanorsoft.com/)
 */
class LinkedProduct extends DataObject
{
    /**
     * @var int
     */
    protected $productLimit;

    /**
     * @var UpSellProductFactory
     */
    protected $upSellProduct;

    /**
     * @var int
     */
    const DEFAULT_UP_SELL_PRODUCT_LIMIT = 3;

    /**
     * LinkedProduct constructor.
     *
     * @param UpSellProductFactory $upSellProduct
     * @param array $data
     * @author Eugene Polischuk <eugene.polischuk@eleanorsoft.com>
     */
    public function __construct(
        UpSellProductFactory $upSellProduct,
        array $data = []
    ) {
        $this->upSellProduct = $upSellProduct;

        $this->setProductLimit(self::DEFAULT_UP_SELL_PRODUCT_LIMIT);

        parent::__construct($data);
    }

    /**
     * Get order.
     *
     * @return Order
     * @author Eugene Polischuk <eugene.polischuk@eleanorsoft.com>
     */
    public function getOrder()
    {
        return $this->getData('order');
    }

    /**
     * Set order.
     *
     * @param Order $order
     * @return $this
     * @author Eugene Polischuk <eugene.polischuk@eleanorsoft.com>
     */
    public function setOrder($order)
    {
        $this->setData('order', $order);

        return $this;
    }

    /**
     * Get product limit.
     *
     * @return int
     * @author Eugene Polischuk <eugene.polischuk@eleanorsoft.com>
     */
    public function getProductLimit()
    {
        return $this->productLimit;
    }

    /**
     * Set product limit.
     *
     * @param int $productLimit
     * @return $this
     * @author Eugene Polischuk <eugene.polischuk@eleanorsoft.com>
     */
    public function setProductLimit($productLimit)
    {
        $this->productLimit = $productLimit;

        return $this;
    }

    /**
     * Get up-sell product model
     *
     * @return UpSellProduct
     * @author Eugene Polischuk <eugene.polischuk@eleanorsoft.com>
     */
    public function getUpSellProductModel()
    {
        return $this->upSellProduct->create();
    }

    /**
     * Get product ids for specified order.
     *
     * @return array
     * @author Eugene Polischuk <eugene.polischuk@eleanorsoft.com>
     */
    public function getProductIds()
    {
        $productIds = [];

        foreach ($this->getOrder()->getItems() as $item) {
            $productIds[] = $item->getProductId();
        }

        return $productIds;
    }

    /**
     * Get product additional attributes.
     *
     * @return array
     * @author Eugene Polischuk <eugene.polischuk@eleanorsoft.com>
     */
    public function geProductAdditionalAttributes()
    {
        return [
            Images::CODE_IMAGE,
            Images::CODE_THUMBNAIL,
            Images::CODE_SMALL_IMAGE,
            ProductInterface::NAME,
            ProductInterface::PRICE,
            ProductAttributeInterface::CODE_SPECIAL_PRICE
        ];
    }

    /**
     * Get up-sell product collection for specified order.
     *
     * @return Collection
     * @author Eugene Polischuk <eugene.polischuk@eleanorsoft.com>
     */
    public function getUpSellProducts()
    {
        $collection = $this->getUpSellProductModel()
            ->getUpSellProductCollection()
            ->addAttributeToSelect($this->geProductAdditionalAttributes())
            ->addProductFilter($this->getProductIds())
            ->addStoreFilter();

        $collection->getSelect()
            ->limit($this->getProductLimit())
            ->orderRand();

        return $collection->load();
    }
}
