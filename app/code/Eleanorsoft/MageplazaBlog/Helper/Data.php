<?php

namespace Eleanorsoft\MageplazaBlog\Helper;

use Mageplaza\Blog\Model\TagFactory;
use Mageplaza\Blog\Model\PostFactory;
use Mageplaza\Blog\Model\TopicFactory;
use Mageplaza\Blog\Model\AuthorFactory;
use Mageplaza\Blog\Model\CategoryFactory;
use Magento\Framework\Filter\TranslitUrl;
use Magento\Framework\App\Helper\Context;
use Magento\Framework\ObjectManagerInterface;
use Mageplaza\Blog\Helper\Data as BaseHelper;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Framework\Stdlib\DateTime\DateTime;
use Eleanorsoft\Lib\Helper\Data as ModuleHelper;

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
     * Module name config path.
     */
    const MODULE_NAME_CONFIG_PATH = 'eleanorsoft_mageplaza_blog';

    /**
     * @var ModuleHelper
     */
    protected $moduleHelper;

    public function __construct(
        Context $context,
        DateTime $dateTime,
        TagFactory $tagFactory,
        PostFactory $postFactory,
        TranslitUrl $translitUrl,
        ModuleHelper $moduleHelper,
        TopicFactory $topicFactory,
        AuthorFactory $authorFactory,
        CategoryFactory $categoryFactory,
        StoreManagerInterface $storeManager,
        ObjectManagerInterface $objectManager
    ) {
        $this->moduleHelper = $moduleHelper;

        $this->_construct();
        parent::__construct(
            $context,
            $objectManager,
            $storeManager,
            $postFactory,
            $categoryFactory,
            $tagFactory,
            $topicFactory,
            $authorFactory,
            $translitUrl,
            $dateTime
        );
    }

    /**
     * Pseudo constructor for additional configuration.
     *
     * @author Eugene Polischuk <eugene.polischuk@eleanorsoft.com>
     */
    public function _construct()
    {
        $this->moduleHelper->setModuleName(self::MODULE_NAME_CONFIG_PATH);
    }

    /**
     * Get if module is enabled.
     *
     * @return bool
     * @author Eugene Polischuk <eugene.polischuk@eleanorsoft.com>
     */
    public function isModuleEnabled()
    {
        return $this->moduleHelper->isModuleEnabled();
    }

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
