<?php
/**
 * @author Amasty Team
 * @copyright Copyright (c) 2016 Amasty (https://www.amasty.com)
 * @package Amasty_Shopby
 */

namespace Amasty\ShopbyPage\Block\Adminhtml\Page\Edit\Tab;

use Magento\Backend\Block\Widget\Form\Generic;
use Magento\Backend\Block\Widget\Tab\TabInterface;
use Magento\Backend\Block\Template\Context;
use Magento\Framework\Data\FormFactory;
use Magento\Framework\Registry;
use Magento\Catalog\Model\Category\Attribute\Source\Page as CategoryAttributeSourcePage;
use Amasty\ShopbyPage\Controller\RegistryConstants;
use Magento\Framework\Api\ExtensibleDataObjectConverter;

class Text extends Generic implements TabInterface
{
    /**
     * @var CategoryAttributeSourcePage
     */
    protected $_categoryAttributeSourcePage;

    /** @var ExtensibleDataObjectConverter  */
    protected $_extensibleDataObjectConverter;

    /**
     * @param Context $context
     * @param Registry $registry
     * @param FormFactory $formFactory
     * @param CategoryAttributeSourcePage $categoryAttributeSourcePage
     * @param ExtensibleDataObjectConverter $extensibleDataObjectConverter
     * @param array $data
     */
    public function __construct(
        Context $context,
        Registry $registry,
        FormFactory $formFactory,
        CategoryAttributeSourcePage $categoryAttributeSourcePage,
        ExtensibleDataObjectConverter $extensibleDataObjectConverter,
        array $data = []
    ) {
        $this->_categoryAttributeSourcePage = $categoryAttributeSourcePage;
        $this->_extensibleDataObjectConverter = $extensibleDataObjectConverter;
        parent::__construct($context, $registry, $formFactory, $data);
    }

    /**
     * Prepare label for tab
     *
     * @return \Magento\Framework\Phrase
     */
    public function getTabLabel()
    {
        return __('Page Text');
    }

    /**
     * Prepare title for tab
     *
     * @return \Magento\Framework\Phrase
     */
    public function getTabTitle()
    {
        return $this->getTabLabel();
    }

    /**
     * {@inheritdoc}
     */
    public function canShowTab()
    {
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function isHidden()
    {
        return false;
    }

    /**
     * Prepare form
     *
     * @return $this
     */
    protected function _prepareForm()
    {
        /** @var \Magento\Framework\Data\Form $form */
        $form = $this->_formFactory->create();

        $form->setHtmlIdPrefix('amasty_shopbypage_');

        /** @var \Amasty\ShopbyPage\Api\Data\PageInterface $model */
        $model = $this->_coreRegistry->registry(RegistryConstants::PAGE);

        $fieldset = $form->addFieldset(
            'page_fieldset',
            ['legend' => __('Page Text'), 'class' => 'fieldset-wide']
        );

        if ($model->getPageId()) {
            $fieldset->addField('page_id', 'hidden', ['name' => 'page_id']);
        }

        $fieldset->addField(
            'title',
            'text',
            [
                'name' => 'title',
                'label' => __('Title'),
                'title' => __('Title')
            ]
        );

        $fieldset->addField(
            'description',
            'textarea',
            [
                'name' => 'description',
                'label' => __('Description'),
                'title' => __('Description')
            ]
        );

        $fieldset->addField('top_block_id', 'select', array(
            'name'     => 'top_block_id',
            'label'    => __('Top CMS block'),
            'values' => $this->_categoryAttributeSourcePage->getAllOptions()
        ));

        /*
             $fieldset->addField('bottom_block_id', 'select', array(
                'name'     => 'bottom_block_id',
                'label'    => __('Bottom CMS block'),
                'values' => $this->_categoryAttributeSourcePage->getAllOptions()
            ));
        */

        $form->setValues(
            $this->_extensibleDataObjectConverter->toFlatArray(
                $model,
                [],
                '\Amasty\ShopbyPage\Api\Data\PageInterface'
            )
        );

        $this->setForm($form);

        return parent::_prepareForm();
    }
}