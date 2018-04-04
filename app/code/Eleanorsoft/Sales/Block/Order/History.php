<?php

namespace Eleanorsoft\Sales\Block\Order;

use Magento\Sales\Model\Order\Config;
use Magento\Catalog\Model\ProductFactory;
use Magento\Sales\Model\Order as OrderItem;
use Magento\Sales\Api\Data\OrderItemInterface;
use Magento\Catalog\Block\Product\ImageBuilder;
use Magento\Catalog\Model\Product as ProductItem;
use Magento\Sales\Block\Order\History as BaseBlock;
use Magento\Framework\View\Element\Template\Context;
use Magento\Customer\Model\Session as CustomerSession;
use Magento\Catalog\Block\Product\Image as ProductImage;
use Magento\Sales\Model\ResourceModel\Order\CollectionFactory as OrderCollectionFactory;

/**
 * Class History
 * Preference class for Magento Sales Order History Block.
 *
 * @package Eleanorsoft\Sales\Block\Order
 * @author Eugene Polischuk <eugene.polischuk@eleanorsoft.com>
 * @copyright Copyright (c) 2018 Eleanorsoft (https://www.eleanorsoft.com/)
 */
class History extends BaseBlock
{
    /**
     * @var ImageBuilder
     */
    protected $imageBuilder;

    /**
     * @var ProductFactory
     */
    protected $productFactory;

    /**
     * History constructor.
     *
     * @param Context $context
     * @param Config $orderConfig
     * @param ImageBuilder $imageBuilder
     * @param ProductFactory $productFactory
     * @param CustomerSession $customerSession
     * @param OrderCollectionFactory $orderCollectionFactory
     * @param array $data
     * @author Eugene Polischuk <eugene.polischuk@eleanorsoft.com>
     */
    public function __construct(
        Context $context,
        Config $orderConfig,
        ImageBuilder $imageBuilder,
        ProductFactory $productFactory,
        CustomerSession $customerSession,
        OrderCollectionFactory $orderCollectionFactory,
        array $data = []
    ) {
        $this->imageBuilder = $imageBuilder;
        $this->productFactory = $productFactory;

        parent::__construct(
            $context,
            $orderCollectionFactory,
            $customerSession,
            $orderConfig,
            $data
        );
    }

    /**
     * Get product image.
     *
     * @param ProductItem $product
     * @param string $imageId
     * @param array $attributes
     * @return ProductImage
     * @author Eugene Polischuk <eugene.polischuk@eleanorsoft.com>
     */
    public function getProductImage($product, $imageId = 'product_base_image', $attributes = [])
    {
        return $this->imageBuilder->setProduct($product)
            ->setImageId($imageId)
            ->setAttributes($attributes)
            ->create();
    }

    /**
     * Get oder first product.
     *
     * @param OrderItem $order
     * @return ProductItem
     * @author Eugene Polischuk <eugene.polischuk@eleanorsoft.com>
     */
    public function getOrderFirstProduct($order)
    {
        $orderItems = $order->getItems();

        /** @var OrderItemInterface $firstOrderItem */
        $firstOrderItem = reset($orderItems);
        $firstProductId = $firstOrderItem->getProductId();

        return $this->productFactory->create()->load($firstProductId);
    }
}
