<?php

namespace Eleanorsoft\Instagram\Block;

use \Exception;
use \Magento\Framework\View\Element\Template;
use \Magento\Framework\View\Element\Template\Context;
use \Eleanorsoft\Instagram\Helper\Config as ModuleConfig;
use \Eleanorsoft\Instagram\Instagram\Api\Adapter\Cosenary\Instagram\ImageAdapter;
use \Eleanorsoft\Instagram\Instagram\Api\Adapter\AdapterInterface as InstagramApiInterface;

/**
 * Class AuthorizeButton
 * Instagram widget block.
 *
 * @author Eugene Polischuk <eugene.polischuk@eleanorsoft.com>
 * @copyright Copyright (c) 2017 Eleanorsoft (https://www.eleanorsoft.com/)
 */
class Widget extends Template
{
    /**
     * Default photos count.
     */
    const DEFAULT_PHOTOS_COUNT = 7;

    /**
     * Instagram photos count.
     *
     * @var int
     */
    private $photosCount;

    /**
     * @var string
     */
    protected $_template = 'widget.phtml';

    /**
     * @var ModuleConfig
     */
    protected $moduleConfig;

    /**
     * @var InstagramApiInterface
     */
    protected $instagramApi;

    /**
     * Widget constructor.
     *
     * @param Context $context
     * @param ModuleConfig $moduleConfig
     * @param InstagramApiInterface $instagramApi
     * @author Eugene Polischuk <eugene.polischuk@eleanorsoft.com>
     */
    public function __construct(
        Context $context,
        ModuleConfig $moduleConfig,
        InstagramApiInterface $instagramApi
    ) {
        $this->moduleConfig = $moduleConfig;
        $this->instagramApi = $instagramApi;

        $this->setPhotosCount(self::DEFAULT_PHOTOS_COUNT);

        parent::__construct($context);
    }

    /**
     * Block pseudo construct.
     *
     * @author Eugene Polischuk <eugene.polischuk@eleanorsoft.com>
     */
    protected function _construct()
    {
        parent::_construct();

        $this->moduleConfig->setStoreId(
            $this->_storeManager->getStore()->getId()
        );
    }

    /**
     * Get Instagram photos count.
     *
     * @return int
     * @author Eugene Polischuk <eugene.polischuk@eleanorsoft.com>
     */
    public function getPhotosCount()
    {
        return $this->photosCount;
    }

    /**
     * Set instagram photos count.
     *
     * @param int $photosCount
     * @author Eugene Polischuk <eugene.polischuk@eleanorsoft.com>
     */
    public function setPhotosCount($photosCount)
    {
        $this->photosCount = $photosCount;
    }

    /**
     * Get photos.
     *
     * @return ImageAdapter[]
     * @author Eugene Polischuk <eugene.polischuk@eleanorsoft.com>
     */
    public function getPhotos()
    {
        if (!$this->moduleConfig->getIsEnabledValue()) {
            return [];
        }

        try {
            return $this->instagramApi->getPhotos($this->getPhotosCount());
        } catch (Exception $ex) {
            $this->moduleConfig->setErrorValue($ex->getMessage());
            $this->moduleConfig->refreshConfig();

            return [];
        }
    }
}
