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
use Amasty\ShopbyPage\Model\Config\Source\Position as SourcePosition;
use Amasty\ShopbyPage\Controller\RegistryConstants;
use Magento\Framework\Api\ExtensibleDataObjectConverter;

class Meta extends Generic implements TabInterface
{
    /** @var  SourcePosition*/
    protected $_sourcePosition;

    /** @var ExtensibleDataObjectConverter  */
    protected $_extensibleDataObjectConverter;

    /**
     * @param Context $context
     * @param Registry $registry
     * @param FormFactory $formFactory
     * @param SourcePosition $sourcePosition
     * @param ExtensibleDataObjectConverter $extensibleDataObjectConverter
     * @param array $data
     */
    public function __construct(
        Context $context,
        Registry $registry,
        FormFactory $formFactory,
        SourcePosition $sourcePosition,
        ExtensibleDataObjectConverter $extensibleDataObjectConverter,
        array $data = []
    ) {
        $this->_sourcePosition = $sourcePosition;
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
        return __('Meta Tags');
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

        /** @var \Amasty\ShopbyPage\Api\Data\PageInterface $model */
        $model = $this->_coreRegistry->registry(RegistryConstants::PAGE);

        $fieldset = $form->addFieldset(
            'meta_fieldset',
            ['legend' => __('Meta Tags'), 'class' => 'fieldset-wide']
        );

        $fieldset->addField(
            'position',
            'select',
            [
                'name' => 'position',
                'label' => __('Add Texts'),
                'title' => __('Add Texts'),
                'options' => $this->_sourcePosition->toArray()
            ]
        );

        $fieldset->addField(
            'meta_title',
            'text',
            [
                'name' => 'meta_title',
                'label' => __('Page Title'),
                'title' => __('Page Title')
            ]
        );

        $fieldset->addField(
            'meta_description',
            'textarea',
            [
                'name' => 'meta_description',
                'label' => __('Meta Description'),
                'title' => __('Meta Description')
            ]
        );

        $fieldset->addField(
            'meta_keywords',
            'textarea',
            [
                'name' => 'meta_keywords',
                'label' => __('Meta Keywords'),
                'title' => __('Meta Keywords')
            ]
        );

        $fieldset->addField(
            'url',
            'text',
            [
                'name' => 'url',
                'label' => __('Canonical Url'),
                'title' => __('Canonical Url'),
                'note' => __('It\'s not the page URL. It\'s HTML tag as per') . '<br/>https://support.google.com/webmasters/answer/139394'
            ]
        );

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