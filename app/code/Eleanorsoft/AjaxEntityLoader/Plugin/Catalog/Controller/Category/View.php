<?php

namespace Eleanorsoft\AjaxEntityLoader\Plugin\Catalog\Controller\Category;
use Magento\Catalog\Controller\Category\View as BaseView;
use Magento\Eav\Model\Entity\Collection\AbstractCollection;
use Magento\Framework\App\Action\Context;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Json\Helper\Data;
use Magento\TestFramework\Event\Magento;


/**
 * Class Index
 * todo: What is its purpose? What does it do?
 *
 * @package Eleanorsoft_
 * @author Pisarenko Denis <denis.pisarenko@eleanorsoft.com>
 * @copyright Copyright (c) 2018 Eleanorsoft (https://www.eleanorsoft.com/)
 */

class View
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
     * @param BaseView $subject
     * @param $page
     * @return \Magento\Framework\Controller\ResultInterface|ResponseInterface
     */
    public function afterExecute(BaseView $subject, $page)
    {
        $data = $this->_request->getParams();
        if ($data && $this->_request->isAjax()) {
                var_dump($data);
            $resultLayout = $this->resultFactory->create(ResultFactory::TYPE_LAYOUT);
            $resultJson = $this->resultFactory->create(ResultFactory::TYPE_JSON);


            $block = $resultLayout->getLayout()->getBlock('category.products.list');
            $collection = $block->getLoadedProductCollection(); /** @var $collection AbstractCollection */

            $size = (int)ceil($collection->getSize() / 9);

            if ($size > 3) {
                return $resultJson->setData(new \stdClass());
            }
            $collection->setPage(7, 9);

            return $resultJson->setData($collection);
        }
        return $page;
    }
}