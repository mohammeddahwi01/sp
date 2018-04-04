<?php

namespace Eleanorsoft\ShippingCustomization\Model\Config\Source;

use Magento\Eav\Model\Entity\Attribute\Source\AbstractSource;

class Options extends AbstractSource
{
    const FREIGHT = 1;
    const NON_FREIGHT = 2;

    /**
     * Get all options
     *
     * @return array
     */
    public function getAllOptions()
    {
        $this->_options =[
            ['label' => 'Default', 'value'=> 0],
            ['label' => 'Freight', 'value'=> self::FREIGHT],
            ['label'=> 'Non-freight', 'value'=> self::NON_FREIGHT]
        ];

        return $this->_options;
    }
}
