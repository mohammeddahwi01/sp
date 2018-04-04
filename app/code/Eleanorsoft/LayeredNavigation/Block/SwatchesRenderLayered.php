<?php

namespace Eleanorsoft\LayeredNavigation\Block;

use Magento\Eav\Model\Entity\Attribute;
use Magento\Framework\View\Element\Template;
use Magento\Catalog\Model\Layer\Filter\Item as FilterItem;
use Eleanorsoft\LayeredNavigation\Block\Navigation\FilterRenderer;
use Magento\Catalog\Model\ResourceModel\Layer\Filter\AttributeFactory;
use Magento\Swatches\Block\LayeredNavigation\RenderLayered as BaseBlock;

/**
 * Preference class for Swatch LayeredNavigation RenderLayered Class.
 *
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 */
class SwatchesRenderLayered extends BaseBlock
{
    /**
     * @var FilterRenderer
     */
    protected $filterRenderer;

    /**
     * SwatchesRenderLayered constructor.
     *
     * @param Attribute $eavAttribute
     * @param Template\Context $context
     * @param FilterRenderer $filterRenderer
     * @param AttributeFactory $layerAttribute
     * @param \Magento\Swatches\Helper\Data $swatchHelper
     * @param \Magento\Swatches\Helper\Media $mediaHelper
     * @param array $data
     * @author Eugene Polischuk <eugene.polischuk@eleanorsoft.com>
     */
    public function __construct(
        Attribute $eavAttribute,
        Template\Context $context,
        FilterRenderer $filterRenderer,
        AttributeFactory $layerAttribute,
        \Magento\Swatches\Helper\Data $swatchHelper,
        \Magento\Swatches\Helper\Media $mediaHelper,
        array $data = []
    ) {
        $this->filterRenderer = $filterRenderer;

        parent::__construct(
            $context,
            $eavAttribute,
            $layerAttribute,
            $swatchHelper,
            $mediaHelper,
            $data
        );
    }

    /**
     * Check if filter value is active for specified filter.
     *
     * @param $filterName
     * @param $filterValue
     * @return bool
     * @author Eugene Polischuk <eugene.polischuk@eleanorsoft.com>
     */
    public function isFilterValueActive($filterName, $filterValue)
    {
        return $this->filterRenderer->isFilterValueActive($filterName, $filterValue);
    }

    /**
     * @return $this
     * @author Eugene Polischuk <eugene.polischuk@eleanorsoft.com>
     */
    protected function _prepareLayout()
    {
        $this->setTemplate('Eleanorsoft_LayeredNavigation::layer/renderer.phtml');

        return parent::_prepareLayout();
    }
}
