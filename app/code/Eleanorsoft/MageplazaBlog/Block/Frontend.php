<?php

namespace Eleanorsoft\MageplazaBlog\Block;

use Mageplaza\Blog\Block\Frontend as BaseBlock;
use Eleanorsoft\MageplazaBlog\Block\Post\Item as PostItem;
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
    /**
     * Get post collection.
     *
     * @return ResourceCollection
     * @author Eugene Polischuk <eugene.polischuk@eleanorsoft.com>
     */
    public function getPostCollection()
    {
        $collection = parent::getPostCollection();

        if (!$this->helperData->isModuleEnabled()) {
            return $collection;
        }

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
}
