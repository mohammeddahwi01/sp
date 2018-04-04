<?php

namespace Eleanorsoft\CategoryColor\Setup;

use Magento\Catalog\Model\Category;
use Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface;
use Magento\Eav\Setup\EavSetupFactory;
use Magento\Framework\Setup\InstallDataInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;


/**
 * Class InstallData
 *
 * @package Eleanorsoft\CategoryColor\Setup
 * @author Pisarenko Denis <denis.pisarenko@eleanorsoft.com>
 * @copyright Copyright (c) 2018 Eleanorsoft (https://www.eleanorsoft.com/)
 */

class InstallData implements InstallDataInterface
{
    private $eavSetupFactory;

    public function __construct(EavSetupFactory $eavSetupFactory)
    {
        $this->eavSetupFactory = $eavSetupFactory;
    }

    /**
     * Installs data for a module
     *
     * @param ModuleDataSetupInterface $setup
     * @param ModuleContextInterface $context
     * @return void
     */
    public function install(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {
        $eavSetup = $this->eavSetupFactory->create(['setup' => $setup]);
        $eavSetup->addAttribute(Category::ENTITY, 'el_color_picker',[
            'type'      =>  'varchar',
            'label'     =>  'Color',
            'input'     =>  'text',
            'visible'   =>  true,
            'required'  =>  false,
            'global'    =>  ScopedAttributeInterface::SCOPE_GLOBAL,
            'group'     =>  'Display Settings',
        ]);
    }
}