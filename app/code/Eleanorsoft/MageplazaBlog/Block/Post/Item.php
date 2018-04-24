<?php

namespace Eleanorsoft\MageplazaBlog\Block\Post;

use Eleanorsoft\MageplazaBlog\Helper\Image;
use Mageplaza\Blog\Block\Frontend;
use Mageplaza\Blog\Model\Post as PostItem;
use Magento\Framework\View\Element\Template;
use Mageplaza\Blog\Helper\Data as HelperData;
use Mageplaza\Blog\Model\Category as PostCategory;
use Magento\Framework\View\Element\Template\Context;

/**
 * Class Item
 * Post item block class.
 *
 * @package Eleanorsoft\MageplazaBlog\Block\Post
 * @author Eugene Polischuk <eugene.polischuk@eleanorsoft.com>
 * @author Denis Pisarenko <denis.pisarenko@eleanorsoft.com>
 * @copyright Copyright (c) 2018 Eleanorsoft (https://www.eleanorsoft.com/)
 */
class Item extends Template
{
    /**
     * @type HelperData
     */
    protected $helperData;

    /**
     * @var Frontend
     */
    protected $frontend;

    /**
     * @var Image
     */
    protected $imageHelper;

    /**
     * Item constructor.
     *
     * @param Context $context
     * @param HelperData $helperData
     * @param Frontend $frontend
     * @param Image $imageHelper
     * @param array $data
     * @author Eugene Polischuk <eugene.polischuk@eleanorsoft.com>
     */
    public function __construct(
        Context $context,
        HelperData $helperData,
        Frontend $frontend,
        Image $imageHelper,
        array $data = []
    ) {
        $this->helperData = $helperData;
        $this->frontend = $frontend;
        $this->imageHelper = $imageHelper;

        parent::__construct($context, $data);
    }

    /**
     * Set post.
     *
     * @param $post
     * @return $this
     * @author Eugene Polischuk <eugene.polischuk@eleanorsoft.com>
     */
    public function setPost($post)
    {
        return $this->setData('post', $post);
    }

    /**
     * Get post.
     *
     * @return PostItem
     * @author Eugene Polischuk <eugene.polischuk@eleanorsoft.com>
     */
    public function getPost()
    {
        return $this->getData('post');
    }

    /**
     * Set post index.
     *
     * @param int $postIndex
     * @return $this
     * @author Eugene Polischuk <eugene.polischuk@eleanorsoft.com>
     */
    public function setPostIndex($postIndex)
    {
        return $this->setData('postIndex', $postIndex);
    }

    /**
     * Get post index.
     *
     * @return int
     * @author Eugene Polischuk <eugene.polischuk@eleanorsoft.com>
     */
    public function getPostIndex()
    {
        return (int)$this->getData('postIndex');
    }

    /**
     * Get post first category.
     *
     * @param PostItem $post
     * @return PostCategory
     * @author Eugene Polischuk <eugene.polischuk@eleanorsoft.com>
     */
    public function getPostFirstCategory($post)
    {
        return $this->helperData->getPostFirstCategory($post);
    }

    /**
     * Get post image url.
     *
     * @param PostItem $post
     * @return string
     * @author Eugene Polischuk <eugene.polischuk@eleanorsoft.com>
     */
    public function getPostImageUrl($post)
    {
        $file = $post->getImage();
        if (is_null($file)) {
            return $this->getDefaultImageUrl();
        }
        return $this->helperData->getImageHelper()
            ->getMediaUrl($file);
    }

    /**
     * @param $date
     * @param bool $monthly
     * @return false|string
     */
    public function getDateFormat($date, $monthly = false)
    {
        return $this->helperData->getDateFormat($date, $monthly);
    }

    /**
     * get default image url
     */
    public function getDefaultImageUrl()
    {
        return $this->frontend->getDefaultImageUrl();
    }

    /**
     * Resize Image Function
     * @param PostItem $post
     * @param null $width
     * @param null $height
     * @return string
     */
    public function resizeImage($post, $width = null, $height = null)
    {
        $image = $post->getImage();

        if (!$image) {
            return $this->getDefaultImageUrl();
        }

        return $this->imageHelper->resizeImage($image, $width, $height);
    }

}
