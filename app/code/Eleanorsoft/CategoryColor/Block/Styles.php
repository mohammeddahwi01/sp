<?php

namespace Eleanorsoft\CategoryColor\Block;


use Magento\Catalog\Model\ResourceModel\Category\CollectionFactory;
use \Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;

/**
 * Class Menu
 * Top menu block with account links
 *
 * @package Eleanorsoft_Authorize
 * @author Konstantin Esin <hello@eleanorsoft.com>
 * @copyright Copyright (c) 2018 Eleanorsoft (https://www.eleanorsoft.com/)
 */
class Styles extends Template
{
    /**
     * @var CollectionFactory
     */
    protected $collectionFactory;

    public function __construct
    (
        Context $context,
        CollectionFactory $collectionFactory,
        array $data = []
    )
    {
        parent::__construct($context, $data);

        $this->collectionFactory = $collectionFactory;
    }

    /**
     * Collection category
     *
     * @return \Magento\Catalog\Model\ResourceModel\Category\Collection
     * @author Pisarenko Denis <denis.pisarenko@eleanorsoft.com>
     * @copyright Copyright (c) 2018 Eleanorsoft (https://www.eleanorsoft.com/)
     */
    public function getCollection()
    {
       $collection = $this->collectionFactory->create();
       $collection->addAttributeToSelect('el_color_picker')
       ->addUrlRewriteToResult();

       return $collection;

    }

    /**
     * Serialize data into string
     *
     * @return bool|string
     * @author Pisarenko Denis <denis.pisarenko@eleanorsoft.com>
     * @copyright Copyright (c) 2018 Eleanorsoft (https://www.eleanorsoft.com/)
     */
    public function getColorsData()
    {
        $colors = [];
        $collection = $this->getCollection();
        foreach ($collection as $item){
            $colors[$item->getId()]['color'] = $item->getData('el_color_picker');
            $colors[$item->getId()]['url'] = $item->getData('request_path');
        }
        return json_encode($colors);
    }
}
