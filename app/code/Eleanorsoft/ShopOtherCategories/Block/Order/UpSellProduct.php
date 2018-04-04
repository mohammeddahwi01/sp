<?php

namespace Eleanorsoft\ShopOtherCategories\Block\Order;

use \Exception;
use \Magento\Sales\Model\Order;
use \Magento\Sales\Model\OrderFactory;
use \Magento\Catalog\Block\Product\Context;
use \Magento\Catalog\Block\Product\AbstractProduct;
use \Eleanorsoft\ShopOtherCategories\Model\Order\LinkedProduct;
use \Eleanorsoft\ShopOtherCategories\Model\Order\LinkedProductFactory;
use \Magento\Catalog\Model\ResourceModel\Product\Link\Product\Collection;

/**
 * Class OnePageSuccess
 * Block class to retrieve up-sell products from order products.
 *
 * @package Eleanorsoft\ShopOtherCategories\Block
 * @author Eugene Polischuk <eugene.polischuk@eleanorsoft.com>
 * @copyright Copyright (c) 2017 Eleanorsoft (https://www.eleanorsoft.com/)
 */
class UpSellProduct extends AbstractProduct
{
    /**
     * @var OrderFactory
     */
    protected $order;

    /**
     * @var LinkedProductFactory
     */
    protected $linkedProduct;

    /**
     * @var Collection
     */
    protected $orderUpSellProducts;

    /**
     * UpSellProduct constructor.
     *
     * @param Context $context
     * @param OrderFactory $order
     * @param LinkedProductFactory $linkedProduct
     * @param array $data
     * @author Eugene Polischuk <eugene.polischuk@eleanorsoft.com>
     */
    public function __construct(
        Context $context,
        OrderFactory $order,
        LinkedProductFactory $linkedProduct,
        array $data = []
    ) {
        $this->order = $order;
        $this->linkedProduct = $linkedProduct;

        parent::__construct($context, $data);
    }

    /**
     * Get order model.
     *
     * @return Order
     * @author Eugene Polischuk <eugene.polischuk@eleanorsoft.com>
     */
    public function getOrderModel()
    {
        return $this->order->create();
    }

    /**
     * Get order product link model.
     *
     * @return LinkedProduct
     * @author Eugene Polischuk <eugene.polischuk@eleanorsoft.com>
     */
    public function getOrderLinkedProductModel()
    {
        return $this->linkedProduct->create();
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
     * @param $order
     * @return $this
     * @author Eugene Polischuk <eugene.polischuk@eleanorsoft.com>
     */
    public function setOrder($order)
    {
        $this->setData('order', $order);

        return $this;
    }

    /**
     * Load order by increment id.
     *
     * @param $id
     * @return $this
     * @throws Exception
     * @author Eugene Polischuk <eugene.polischuk@eleanorsoft.com>
     */
    public function loadOrderById($id)
    {
        $order = $this->getOrderModel()->load($id);

        if (!$order->getId()) {
            throw new Exception("Order id <$id> is undefined");
        }

        $this->setOrder($order);

        return $this;
    }

    /**
     * Load order by increment id.
     *
     * @param $incrementId
     * @return $this
     * @throws Exception
     * @author Eugene Polischuk <eugene.polischuk@eleanorsoft.com>
     */
    public function loadOrderByIncrementId($incrementId)
    {
        $order = $this->getOrderModel()->loadByIncrementId($incrementId);

        if (!$order->getId()) {
            throw new Exception("Order increment id <$incrementId> is undefined");
        }

        $this->setOrder($order);

        return $this;
    }

    /**
     * Get order up-sell product collection.
     *
     * @return Collection
     * @author Eugene Polischuk <eugene.polischuk@eleanorsoft.com>
     */
    public function getOrderUpSellProducts()
    {
        if (!$this->orderUpSellProducts) {
            $this->orderUpSellProducts = $this->getOrderLinkedProductModel()
                ->setOrder($this->getOrder())
                ->getUpSellProducts();
        }

        return $this->orderUpSellProducts;
    }
}
