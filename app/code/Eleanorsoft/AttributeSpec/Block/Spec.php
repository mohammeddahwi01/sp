<?php

namespace Eleanorsoft\AttributeSpec\Block;

use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Framework\View\Element\Template;

/**
 * Class Spec
 *
 * @package Eleanorsoft_AttributeSpec
 * @author Pisarenko Denis <denis.pisarenko@eleanorsoft.com>
 * @copyright Copyright (c) 2018 Eleanorsoft (https://www.eleanorsoft.com/)
 */
class Spec extends Template
{
    /**
     *
     * @var ProductRepositoryInterface
     */
    protected $productRepository;

    /**
     * Spec constructor.
     * @param Template\Context $context
     * @param ProductRepositoryInterface $productRepository
     * @param array $data
     */
    public function __construct(
        Template\Context $context,
        ProductRepositoryInterface $productRepository,
        array $data = [])
    {
        parent::__construct($context, $data);
        $this->productRepository = $productRepository;
    }

    /**
     * return attribute spec
     *
     * @return null|string
     */
    public function getSpec()
    {
        $productId = $this->getRequest()->getParam('id');

        $product = $this->productRepository->getById($productId);

        $spec = $product->getData('es_spec');
        if (!$spec){
            return null;
        }
        return $spec;
    }
}