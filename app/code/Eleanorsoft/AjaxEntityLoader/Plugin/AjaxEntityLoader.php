<?php

namespace Eleanorsoft\AjaxEntityLoader\Plugin;

use Magento\Eav\Model\Entity\Collection\AbstractCollection;
use Magento\Framework\App\Action\Context;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Json\Helper\Data;

/**
 * Class AjaxEntityLoader
 * todo: What is its purpose? What does it do?
 *
 * @package Eleanorsoft_
 * @author Pisarenko Denis <denis.pisarenko@eleanorsoft.com>
 * @copyright Copyright (c) 2018 Eleanorsoft (https://www.eleanorsoft.com/)
 */

abstract class AjaxEntityLoader
{

    /**
     * @var Data
     */
    protected $helper;

    /**
     * @var \Magento\Framework\App\RequestInterface
     */
    protected $_request;

    /**
     * @var \Magento\Framework\App\ResponseInterface
     */
    protected $_response;

    /**
     * @var \Magento\Framework\Controller\ResultFactory
     */
    protected $resultFactory;

    /**
     * Index constructor.
     * @param Context $context
     * @param Data $helper
     */
    public function __construct
    (
        Context $context,
        Data $helper
    )
    {
        $this->helper = $helper;
        $this->_request = $context->getRequest();
        $this->_response = $context->getResponse();
        $this->resultFactory = $context->getResultFactory();
    }

    /**
     * Dispatch request
     *
     * @param $subject
     * @param $page
     * @return \Magento\Framework\Controller\ResultInterface|ResponseInterface
     */
    public function afterExecute($subject, $page)
    {
        $page = $this->_request->getParam('p');
        $qty = $this->_request->getParam('qty');
        if ($page && $qty && $this->_request->isAjax()) {


            $resultJson = $this->resultFactory->create(ResultFactory::TYPE_JSON);

            $block = $this->getBlock('category.products.list');
            $collection = $this->getCollection($block);/** @var $collection AbstractCollection */

            $size = (int)ceil($collection->getSize() / $qty);

            if ($page > $size) {
                return $resultJson->setData(new \stdClass());
            }
            $collection->setPage($page, $qty);

            return $resultJson->setData($collection);
        }
        return $page;
    }

    private function getBlock($title)
    {
        $resultLayout = $this->resultFactory->create(ResultFactory::TYPE_LAYOUT);
        $block = $resultLayout->getLayout()->getBlock($title);

        return $block;
    }

    /**
     * Init collection
     *
     * @param $block
     * @return mixed
     */
    protected abstract function getCollection($block);
}