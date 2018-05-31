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
     * @var \Magento\Framework\Controller\ResultFactory
     */
    protected $resultFactory;

    /**
     * @var \Magento\Framework\App\RequestInterface
     */
    protected $_request;

    /**
     * Index constructor.
     * @param Context $context
     */
    public function __construct
    (
        Context $context
    )
    {
        $this->resultFactory = $context->getResultFactory();
        $this->_request = $context->getRequest();
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

        if ($this->_request->isAjax()) {
            $resultRaw = $this->resultFactory->create(ResultFactory::TYPE_RAW);

            $title_block = $this->getTitleBlock();
            $block = $this->getBlock($title_block);

            $this->beforeHtml();

            $output = $block->toHtml();
            return $resultRaw->setContents($output);
        }
        return $page;
    }

    /**
     * Init layout
     *
     * @return mixed
     */
    public function getLayout()
    {
        $resultLayout = $this->resultFactory->create(ResultFactory::TYPE_LAYOUT);
        $layout = $resultLayout->getLayout();

        return $layout;
    }
    /**
     * Init block
     *
     * @param $title
     * @return mixed
     */
    protected function getBlock($title)
    {
        $layout = $this->getLayout();
        $block = $layout->getBlock($title);

        return $block;
    }

    /**
     * Get name block
     *
     * @return string
     */
    protected abstract function getTitleBlock();


    protected function beforeHtml()
    {
    }
}