<?php

namespace Eleanorsoft\MageplazaBlog\Helper;

use Mageplaza\Blog\Helper\Data as BaseHelper;

/**
 * Class Data
 * Preference class for Mageplaza Blog Helper.
 *
 * @package Eleanorsoft\MageplazaBlog\Helper
 * @author Eugene Polischuk <eugene.polischuk@eleanorsoft.com>
 * @copyright Copyright (c) 2018 Eleanorsoft (https://www.eleanorsoft.com/)
 */
class Data extends BaseHelper
{
    /**
     * Frontend route.
     */
    const FRONTEND_ROUTE = 'es_mpblog';

    /**
     * Get post first category.
     *
     * @param \Mageplaza\Blog\Model\Post $post
     * @return \Magento\Framework\DataObject
     * @author Eugene Polischuk <eugene.polischuk@eleanorsoft.com>
     */
    public function getPostFirstCategory($post)
    {
        /** @var \Mageplaza\Blog\Model\ResourceModel\Category\Collection $collection */
        $collection = $this->getCategoryCollection($post->getCategoryIds());

        return $collection->getFirstItem();
    }
}
