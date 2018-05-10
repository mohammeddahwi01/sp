<?php

namespace Eleanorsoft\MageplazaBlog\Block;

use Magento\Cms\Model\Template\FilterProvider;
use Magento\Customer\Api\CustomerRepositoryInterface;
use Magento\Framework\View\Element\Template\Context;
use Mageplaza\Blog\Block\Frontend as BaseBlock;
use Eleanorsoft\MageplazaBlog\Block\Post\Item as PostItem;
use Mageplaza\Blog\Helper\Data as HelperData;
use Mageplaza\Blog\Model\CommentFactory;
use Mageplaza\Blog\Model\LikeFactory;
use Mageplaza\Blog\Model\ResourceModel\Post\Collection as ResourceCollection;

/**
 * Class Frontend
 * Preference class for Mageplaza Blog Frontend Block.
 *
 * @package Eleanorsoft\MageplazaBlog\Block
 * @author Eugene Polischuk <eugene.polischuk@eleanorsoft.com>
 * @copyright Copyright (c) 2018 Eleanorsoft (https://www.eleanorsoft.com/)
 */
class Frontend extends BaseBlock
{

    public function __construct(Context $context, FilterProvider $filterProvider, CommentFactory $commentFactory, LikeFactory $likeFactory, CustomerRepositoryInterface $customerRepository, HelperData $helperData, array $data = [])
    {
        parent::__construct($context, $filterProvider, $commentFactory, $likeFactory, $customerRepository, $helperData, $data);
    }

    /**
     * Get post collection.
     *
     * @return ResourceCollection
     * @author Eugene Polischuk <eugene.polischuk@eleanorsoft.com>
     */
    public function getPostCollection()
    {
        $collection = parent::getPostCollection();

        return $collection
            ->setPageSize($this->getPostPerPageCount())
            ->setCurPage(1);
    }

    /**
     * Get posts per page count.
     *
     * @return int
     * @author Eugene Polischuk <eugene.polischuk@eleanorsoft.com>
     */
    public function getPostPerPageCount()
    {
        return $this->getData('postPerPageCount');
    }

    /**
     * Set posts per page count.
     *
     * @param int $postPerPageCount
     * @author Eugene Polischuk <eugene.polischuk@eleanorsoft.com>
     */
    public function setPostPerPageCount($postPerPageCount)
    {
        $this->setData('postPerPageCount', $postPerPageCount);
    }

    /**
     * Get posts ajax url.
     *
     * @return string
     * @author Eugene Polischuk <eugene.polischuk@eleanorsoft.com>
     */
    public function getAjaxUrl()
    {
        return $this->getUrl(
            \Eleanorsoft\MageplazaBlog\Helper\Data::FRONTEND_ROUTE .
            '/post'
        );
    }

    /**
     * Get post item html.
     *
     * @param PostItem $post
     * @return string
     * @author Eugene Polischuk <eugene.polischuk@eleanorsoft.com>
     */
    public function getPostItemHtml($post)
    {
        static $postIndex = 1;

        /** @var PostItem $postItemBlock */
        $postItemBlock = $this->getChildBlock('mpblog_post_item');

        if (!$postItemBlock) {
            $postItemBlock = $this->getLayout()
                ->createBlock(PostItem::class)
                ->setTemplate('Eleanorsoft_MageplazaBlog::post/item.phtml');
        }

        return $postItemBlock->setData([
            'post' => $post,
            'postIndex' => $postIndex++
        ])->toHtml();
    }

    /**
     * Get posts html.
     *
     * @param ResourceCollection $collection
     * @return string
     * @author Eugene Polischuk <eugene.polischuk@eleanorsoft.com>
     */
    public function getPostItemsHtml($collection)
    {
        $html = '';

        foreach ($collection as $post) {
            $html .= $this->getPostItemHtml($post);
        }

        return $html;
    }

    /**
     * Override this function to apply collection for each type
     *
     * @return \Mageplaza\Blog\Model\ResourceModel\Post\Collection
     */
    public function getCollection()
    {
        return $this->helperData->getPostCollection();
    }
}
