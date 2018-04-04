<?php

namespace Eleanorsoft\Sales\Block\Order\Item\Renderer;

use Magento\Sales\Model\Order\Config;
use Magento\Sales\Model\Order as OrderItem;
use Magento\Catalog\Block\Product\ImageBuilder;
use Magento\Catalog\Model\Product as ProductItem;
use Magento\Sales\Block\Order\Item\Renderer\DefaultRenderer as BaseBlock;
use Magento\Framework\View\Element\Template\Context;
use Magento\Customer\Model\Session as CustomerSession;
use Magento\Catalog\Block\Product\Image as ProductImage;

/**
 * Class DefaultRenderer
 * Preference class for Magento Sales Order View Default Item Renderer Block.
 *
 * @package Eleanorsoft\Sales\Block\Order
 * @author Konstantin Esin <hello@eleanorsoft.com>
 * @copyright Copyright (c) 2018 Eleanorsoft (https://www.eleanorsoft.com/)
 */
class DefaultRenderer extends BaseBlock
{
    /**
     * @var ImageBuilder
     */
    protected $imageBuilder;

    /**
     * View constructor.
     *
     * @param Context $context
     * @param \Magento\Framework\Stdlib\StringUtils $string
     * @param ProductItem\OptionFactory $productOptionFactory
     * @param ImageBuilder $imageBuilder
     * @param array $data
     * @author Konstantin Esin <hello@eleanorsoft.com>
     */
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Magento\Framework\Stdlib\StringUtils $string,
        \Magento\Catalog\Model\Product\OptionFactory $productOptionFactory,
        ImageBuilder $imageBuilder,
        array $data = []
    ) {
        $this->imageBuilder = $imageBuilder;

        parent::__construct(
            $context,
            $string,
            $productOptionFactory,
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
}
