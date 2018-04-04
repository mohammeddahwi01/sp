<?php

namespace Eleanorsoft\MageplazaBlog\Block\Category;

use Mageplaza\Blog\Model\LikeFactory;
use Mageplaza\Blog\Model\CommentFactory;
use Mageplaza\Blog\Model\CategoryFactory;
use Mageplaza\Blog\Block\Category\Widget as BaseBlock;
use Mageplaza\Blog\Model\ResourceModel\Post\Collection;

/**
 * Class Widget
 * Preference class for Mageplaza Blog Widget Block.
 *
 * @package Eleanorsoft\MageplazaBlog\Block\Category
 * @author Eugene Polischuk <eugene.polischuk@eleanorsoft.com>
 * @copyright Copyright (c) 2018 Eleanorsoft (https://www.eleanorsoft.com/)
 */
class Widget extends BaseBlock
{
    /**
     * Get category item html.
     *
     * @param array $value
     * @return string
     * @author Eugene Polischuk <eugene.polischuk@eleanorsoft.com>
     */
    public function getCategoryItemHtml($value)
    {
        $label = ucfirst($value['text']);
        $url = $this->getCategoryUrl($value['url']);
        $id = array_key_exists('id', $value) ? $value['id'] : -1;

        return '<li class="category-item">' .
                    '<a class="list-categories" href="javascript:void(0)" data-category-id="' . $id . '">' .
                        $label .
                    '</a>' .
                '</li>';
    }

    /**
     * Get category tree html.
     *
     * @param array $tree
     * @return \Magento\Framework\Phrase|string
     * @author Eugene Polischuk <eugene.polischuk@eleanorsoft.com>
     */
    public function getCategoryTreeHtml($tree)
    {
        if (!$tree) {
            return __('No Categories.');
        }

        $html = $this->getCategoryItemHtml([
            'text' => __('All'),
            'url' => $this->helperData->getBlogUrl()
        ]);

        foreach ($tree as $value) {
            if (!$value) {
                continue;
            }

            /** @var Collection $categoryPostCollection */
            $categoryPostCollection = $this->helperData->categoryFactory->create()
                ->load($value['id'])
                ->getSelectedPostsCollection();

            if (!$categoryPostCollection || !$categoryPostCollection->getSize()) {
                continue;
            }

            $html .= $this->getCategoryItemHtml($value);
        }

        return $html;
    }
}
