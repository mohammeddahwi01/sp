<?php

namespace Eleanorsoft\LayeredNavigation\Model;

use Magento\Catalog\Model\Layer;
use Magento\Framework\App\RequestInterface;
use Magento\CatalogSearch\Model\Layer\Filter\Attribute;

/**
 * Class CatalogSearchLayerFilterAttribute
 * Preference class for Filter\Attribute,
 * which adds filters to layer and temp layer.
 *
 * @package Eleanorsoft\LayeredNavigation\Model
 * @author Eugene Polischuk <eugene.polischuk@eleanorsoft.com>
 * @copyright Copyright (c) 2017 Eleanorsoft (https://www.eleanorsoft.com/)
 */
class CatalogSearchLayerFilterAttribute extends Attribute
{
    /**
     * @var Layer
     */
    private $tempLayer;

    /**
     * Get temporary layer.
     *
     * @return Layer
     * @author Eugene Polischuk <eugene.polischuk@eleanorsoft.com>
     */
    public function getTempLayer()
    {
        return $this->tempLayer;
    }

    /**
     * Set temporary layer.
     *
     * @param $layer
     * @author Eugene Polischuk <eugene.polischuk@eleanorsoft.com>
     */
    public function setTempLayer($layer)
    {
        $this->tempLayer = $layer;
    }

    /**
     * Get layer.
     *
     * @return Layer
     * @author Eugene Polischuk <eugene.polischuk@eleanorsoft.com>
     */
    public function getLayer()
    {
        return $this->getTempLayer() ?: parent::getLayer();
    }

    /**
     * Apply filter to layer and layer fulltext product collection.
     *
     * @param RequestInterface $request
     * @return $this
     * @author Eugene Polischuk <eugene.polischuk@eleanorsoft.com>
     */
    public function apply(RequestInterface $request)
    {
        $attributeValue = $request->getParam($this->getRequestVar());

        if (empty($attributeValue)) {
            return $this;
        }

        $this->addFilterToLayer($attributeValue);
        $this->addFilterToFulltextProductCollection($attributeValue);

        return $this;
    }

    /**
     * Add filter to layer fulltext product collection.
     *
     * @param $attributeValueParam
     * @author Eugene Polischuk <eugene.polischuk@eleanorsoft.com>
     */
    protected function addFilterToFulltextProductCollection($attributeValueParam)
    {
        if (!$this->getTempLayer()) {
            $this->getLayer()->getProductCollection()
                ->addFieldToFilter(
                    $this->getAttributeModel()->getAttributeCode(),
                    $attributeValueParam
                );
        }
    }

    /**
     * Add filter to layer state.
     *
     * @param $attributeValueParam
     * @author Eugene Polischuk <eugene.polischuk@eleanorsoft.com>
     */
    protected function addFilterToLayer($attributeValueParam)
    {
        array_map(function ($attributeValue) {
            $this->getLayer()->getState()->addFilter(
                $this->_createItem($this->getOptionText($attributeValue), $attributeValue)
            );
        }, is_array($attributeValueParam) ? $attributeValueParam : [$attributeValueParam]);
    }
}
