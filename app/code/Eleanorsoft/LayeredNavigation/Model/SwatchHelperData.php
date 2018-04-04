<?php

namespace Eleanorsoft\LayeredNavigation\Model;

use Magento\Swatches\Helper\Data as BaseHelper;
use Magento\Catalog\Model\Product as ModelProduct;
use Magento\Catalog\Api\Data\ProductInterface as Product;
use Magento\Catalog\Model\ResourceModel\Product\CollectionFactory;
use Magento\Catalog\Model\ResourceModel\Product\Collection as ProductCollection;
use Magento\Swatches\Model\ResourceModel\Swatch\CollectionFactory as SwatchCollectionFactory;

/**
 * Preference class for Swatch Helper Data Class.
 *
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 */
class SwatchHelperData extends BaseHelper
{
    /**
     * Load Variation Product using fallback.
     *
     * @param Product $parentProduct
     * @param array $attributes
     * @return bool|Product
     */
    public function loadVariationByFallback(Product $parentProduct, array $attributes)
    {
        if (! $this->isProductHasSwatch($parentProduct)) {
            return false;
        }

        $productCollection = $this->productCollectionFactory->create();
        $this->addFilterByParentPublic($productCollection, $parentProduct->getId());

        $configurableAttributes = $this->getAttributesFromConfigurable($parentProduct);
        $allAttributesArray = [];
        foreach ($configurableAttributes as $attribute) {
            $allAttributesArray[$attribute['attribute_code']] = $attribute['default_value'];
        }

        $resultAttributesToFilter = array_merge(
            $attributes,
            array_diff_key($allAttributesArray, $attributes)
        );

        $this->addFilterByAttributesPublic($productCollection, $resultAttributesToFilter);

        $variationProduct = $productCollection->getFirstItem();
        if ($variationProduct && $variationProduct->getId()) {
            return $this->productRepository->getById($variationProduct->getId());
        }

        return false;
    }

    /**
     * Create public method from private one.
     * Add condition to filter logic.
     *
     * @param ProductCollection $productCollection
     * @param array $attributes
     * @return void
     */
    private function addFilterByAttributesPublic(ProductCollection $productCollection, array $attributes)
    {
        foreach ($attributes as $code => $option) {
            $condition = $code == 'color' ? 'in' : 'eq';

            $productCollection->addAttributeToFilter($code, [$condition => $option]);
        }
    }

    /**
     * Create public method from private one.
     *
     * @param ProductCollection $productCollection
     * @param integer $parentId
     * @return void
     */
    public function addFilterByParentPublic(ProductCollection $productCollection, $parentId)
    {
        $tableProductRelation = $productCollection->getTable('catalog_product_relation');
        $productCollection
            ->getSelect()
            ->join(
                ['pr' => $tableProductRelation],
                'e.entity_id = pr.child_id'
            )
            ->where('pr.parent_id = ?', $parentId);
    }
}
