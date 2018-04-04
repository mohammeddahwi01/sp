<?php
/**
 * @author Amasty Team
 * @copyright Copyright (c) 2016 Amasty (https://www.amasty.com)
 * @package Amasty_Shopby
 */


namespace Amasty\Shopby\Block\Navigation;


class State extends \Magento\LayeredNavigation\Block\Navigation\State
{
    /**
     * @var string
     */
    protected $_template = 'layer/state.phtml';

    /** @var \Amasty\Shopby\Helper\FilterSetting  */
    protected $filterSettingHelper;

    /**
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param \Magento\Catalog\Model\Layer\Resolver $layerResolver
     * @param \Amasty\Shopby\Helper\FilterSetting $filterSettingHelper
     * @param \Amasty\Shopby\Model\UrlManager $urlManager
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Magento\Catalog\Model\Layer\Resolver $layerResolver,
        \Amasty\Shopby\Helper\FilterSetting $filterSettingHelper,
        array $data = []
    )
    {
        $this->filterSettingHelper = $filterSettingHelper;
        parent::__construct($context, $layerResolver, $data);
    }

    /**
     * @param \Magento\Catalog\Model\Layer\Filter\FilterInterface $filter
     * @return \Amasty\Shopby\Api\Data\FilterSettingInterface
     */
    public function getFilterSetting(\Magento\Catalog\Model\Layer\Filter\FilterInterface $filter)
    {
        return $this->filterSettingHelper->getSettingByLayerFilter($filter);
    }

    /**
     * @param \Amasty\Shopby\Model\Layer\Filter\Item $filter
     * @param bool|false $showLabels
     * @return mixed
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getSwatchHtml(\Amasty\Shopby\Model\Layer\Filter\Item $filter, $showLabels = false)
    {
        return $this->getLayout()->createBlock(
                    'Amasty\Shopby\Block\Navigation\State\Swatch'
                )
                ->setFilter($filter)
                ->showLabels($showLabels)
                ->toHtml();
    }
}