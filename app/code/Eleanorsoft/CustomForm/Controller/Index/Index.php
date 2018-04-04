<?php

namespace Eleanorsoft\CustomForm\Controller\Index;
use \Eleanorsoft\CustomForm\Controller\Index as BaseIndex;


/**
 * Class Index
 * Should be overridden in child modules. See example.
 *
 * @package Eleanorsoft_CustomForm
 * @author Pisarenko Denis <denis.pisarenko@eleanorsoft.com>
 * @copyright Copyright (c) 2018 Eleanorsoft (https://www.eleanorsoft.com/)
 */

abstract class Index extends BaseIndex
{
    /**
     * Render form
     * @author Pisarenko Denis <denis.pisarenko@eleanorsoft.com>
     * @copyright Copyright (c) 2018 Eleanorsoft (https://www.eleanorsoft.com/)
     */
    public function execute()
    {
        $this->_view->loadLayout();
        $this->_view->renderLayout();
    }
}
