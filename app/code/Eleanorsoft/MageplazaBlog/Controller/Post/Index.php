<?php

namespace Eleanorsoft\MageplazaBlog\Controller\Post;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Mageplaza\Blog\Helper\Data as HelperData;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Framework\View\Result\PageFactory;
use Magento\Framework\Exception\NotFoundException;
use Magento\Framework\Controller\Result\Raw as RawResult;
use Eleanorsoft\MageplazaBlog\Block\Frontend as PostBlock;
use Magento\Framework\Controller\Result\RawFactory as RawResultFactory;

/**
 * Class Index
 * Ajax controller class for getting blog posts.
 *
 * @package Eleanorsoft\MageplazaBlog\Controller\Post
 * @author Eugene Polischuk <eugene.polischuk@eleanorsoft.com>
 * @copyright Copyright (c) 2018 Eleanorsoft (https://www.eleanorsoft.com/)
 */
class Index extends Action
{
    /**
     * @var HelperData
     */
    public $helperData;

    /**
     * @var StoreManagerInterface
     */
    public $storeManager;

    /**
     * @var RawResultFactory
     */
    public $rawResultFactory;

    /**
     * @var PageFactory
     */
    public $resultPageFactory;

    /**
     * Index constructor.
     *
     * @param \Magento\Framework\App\Action\Context $context
     * @param \Magento\Framework\View\Result\PageFactory $resultPageFactory
     */
    public function __construct(
        Context $context,
        HelperData $helperData,
        PageFactory $resultPageFactory,
        RawResultFactory $rawResultFactory,
        StoreManagerInterface $storeManager
    ) {
        $this->helperData = $helperData;
        $this->storeManager = $storeManager;
        $this->rawResultFactory = $rawResultFactory;
        $this->resultPageFactory = $resultPageFactory;

        parent::__construct($context);
    }

    /**
     * Get blog posts via ajax.
     *
     * @return RawResult
     * @throws NotFoundException
     * @author Eugene Polischuk <eugene.polischuk@eleanorsoft.com>
     */
    public function execute()
    {
        if (!$this->getRequest()->isAjax()) {
            throw new NotFoundException(__('404 Not Found'));
        }

        /** @var RawResult $result */
        $result = $this->rawResultFactory->create();
        $collection = $this->helperData->getPostCollection();
        $curPage = $this->getRequest()->getParam('curPage');
        $pageSize = $this->getRequest()->getParam('pageSize');

        if ($curPage <= ceil($collection->getSize() / $pageSize)) {
            $postItemBlock = $this->resultPageFactory->create()->getLayout()
                ->createBlock(PostBlock::class);

            $collection->setPageSize($pageSize)->setCurPage($curPage);

            $result->setContents($postItemBlock->getPostItemsHtml($collection));
        }

        return $result->setHeader('Content-Type', 'text/html');
    }
}
