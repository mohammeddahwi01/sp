<?php
/**
 * @author Amasty Team
 * @copyright Copyright (c) 2016 Amasty (https://www.amasty.com)
 * @package Amasty_Shopby
 */

/**
 * Created by PhpStorm.
 * User: yuri
 * Date: 23/12/15
 * Time: 15:21
 */

namespace Amasty\Shopby\Model\Source;

class DisplayMode implements \Magento\Framework\Option\ArrayInterface
{
    const MODE_DEFAULT = 0;
    const MODE_DROPDOWN = 1;
    const MODE_SLIDER  = 2;
    const MODE_FROM_TO_ONLY  = 3;
    const MODE_IMAGES = 4;
    const MODE_IMAGES_LABELS = 5;
    const MODE_TEXT_SWATCH = 6;


    const ATTRUBUTE_DEFAULT = 'default';
    const ATTRUBUTE_DECIMAL = 'decimal';

    protected $attributeType = self::ATTRUBUTE_DEFAULT;

    /** @var  \Magento\Catalog\Model\ResourceModel\Eav\Attribute */
    protected $attribute;


    public function setAttributeType($attributeType)
    {
        $this->attributeType = $attributeType;
        return $this;
    }

    public function setAttribute(\Magento\Catalog\Model\ResourceModel\Eav\Attribute $attribute)
    {
        $this->setAttributeType($attribute->getBackendType());
        $this->attribute = $attribute;
        return $this;
    }

    public function showSwatchOptions()
    {
        $show = true;

        if (
            $this->attribute &&
            $this->attribute->getId() &&
            $this->attribute->getFrontendInput() != 'select'
        ) {
            $show = false;
        }

        return $show;
    }

    /**
     * Options getter
     *
     * @return array
     */
    public function toOptionArray()
    {
        $options = [];
        foreach ($this->_getOptions() as $optionValue=>$optionLabel) {
            $options[] = ['value'=>$optionValue, 'label'=>$optionLabel];
        }
        return $options;
    }

    /**
     * Get options in "key-value" format
     *
     * @return array
     */
    public function toArray()
    {
        return $this->_getOptions();
    }

    protected function _getOptions()
    {
        $options = [
            self::MODE_DEFAULT => __('Labels'),
            self::MODE_DROPDOWN => __('Dropdown')
        ];

        if ($this->showSwatchOptions()){
            $options[self::MODE_IMAGES] = __('Images');
            $options[self::MODE_IMAGES_LABELS] = __('Images & Labels');
            $options[self::MODE_TEXT_SWATCH] = __('Text Swatches');
        }

        switch($this->attributeType) {
            case self::ATTRUBUTE_DECIMAL:
                $options[self::MODE_DEFAULT] = __('Ranges');
                $options[self::MODE_SLIDER] = __('Slider');
                $options[self::MODE_FROM_TO_ONLY] = __('From-To Only');
                break;
            default:
                break;
        }

        return $options;
    }

    public function getInputTypeMap()
    {
        return [
            self::MODE_DEFAULT => 'select',
            self::MODE_DROPDOWN => 'select',
//        self::MODE_SLIDER  = 2;
//        self::MODE_FROM_TO_ONLY  = 3;
            self::MODE_IMAGES => \Magento\Swatches\Model\Swatch::SWATCH_TYPE_VISUAL_ATTRIBUTE_FRONTEND_INPUT,
            self::MODE_IMAGES_LABELS => \Magento\Swatches\Model\Swatch::SWATCH_TYPE_VISUAL_ATTRIBUTE_FRONTEND_INPUT,
            self::MODE_TEXT_SWATCH => \Magento\Swatches\Model\Swatch::SWATCH_TYPE_TEXTUAL_ATTRIBUTE_FRONTEND_INPUT
        ];
    }
}
