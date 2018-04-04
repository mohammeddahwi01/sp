<?php

namespace Eleanorsoft\MageplazaBlog\Block\Post;

use Mageplaza\Blog\Model\Post as PostItem;
use Mageplaza\Blog\Block\Post\View as BaseBlock;
use Mageplaza\Blog\Model\ResourceModel\Post\Collection as PostCollection;

/**
 * Class View
 * Preference class for Mageplaza Blog Post View Block.
 *
 * @package Eleanorsoft\MageplazaBlog\Block\Post
 * @author Eugene Polischuk <eugene.polischuk@eleanorsoft.com>
 * @copyright Copyright (c) 2018 Eleanorsoft (https://www.eleanorsoft.com/)
 */
class View extends BaseBlock
{
    /**
     * Get next post url.
     *
     * @param PostItem $post
     * @return string
     * @author Eugene Polischuk <eugene.polischuk@eleanorsoft.com>
     */
    public function getNextPostUrl($post)
    {
        return $this->getSiblingPostUrl($post->getNextPost());
    }

    /**
     * Get previous post url.
     *
     * @param PostItem $post
     * @return string
     * @author Eugene Polischuk <eugene.polischuk@eleanorsoft.com>
     */
    public function getPrevPostUrl($post)
    {
        return $this->getSiblingPostUrl($post->getPrevPost());
    }

    /**
     * Get sibling post url.
     *
     * @param PostCollection $postCollection
     * @return string
     * @author Eugene Polischuk <eugene.polischuk@eleanorsoft.com>
     */
    public function getSiblingPostUrl($postCollection)
    {
        $siblingPost = $postCollection->getFirstItem();

        return $siblingPost->isEmpty() ? '' : $siblingPost->getUrl();
    }
}
