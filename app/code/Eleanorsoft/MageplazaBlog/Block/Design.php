<?php

namespace Eleanorsoft\MageplazaBlog\Block;

use \Mageplaza\Blog\Block\Design as BaseBlock;

/**
 * Class Design
 * Preference class for Mageplaza Blog Design Block.
 *
 * @package Eleanorsoft\MageplazaBlog\Block
 * @author Eugene Polischuk <eugene.polischuk@eleanorsoft.com>
 * @copyright Copyright (c) 2018 Eleanorsoft (https://www.eleanorsoft.com/)
 */
class Design extends BaseBlock
{
    /**
     * @return $this
     * @author Eugene Polischuk <eugene.polischuk@eleanorsoft.com>
     */
    protected function _prepareLayout()
    {
        $this->setTemplate('design.phtml');

        return parent::_prepareLayout();
    }
}
