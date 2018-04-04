<?php

namespace Eleanorsoft\Sales\Plugin\Controller;

use Magento\Framework\View\Result\Page as ResultPage;
use Magento\Sales\Controller\Order\History as HistoryController;

/**
 * Class OrderHistoryPlugin
 * Plugin class for order history controller.
 *
 * @package Eleanorsoft\Sales\Plugin\Controller
 * @author Eugene Polischuk <eugene.polischuk@eleanorsoft.com>
 * @copyright Copyright (c) 2018 Eleanorsoft (https://www.eleanorsoft.com/)
 */
class OrderHistoryPlugin
{
    /**
     * Change order history page title in controller.
     *
     * @param HistoryController $subject
     * @param ResultPage $result
     * @return ResultPage
     * @author Eugene Polischuk <eugene.polischuk@eleanorsoft.com>
     */
    public function afterExecute(HistoryController $subject, ResultPage $result)
    {
        $result->getConfig()->getTitle()->set(__('Order History'));

        return $result;
    }
}
