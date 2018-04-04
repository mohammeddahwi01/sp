<?php

namespace Eleanorsoft\OrderNote\Setup;

use \Magento\Framework\Setup\SchemaSetupInterface;
use \Magento\Framework\Setup\InstallSchemaInterface;
use \Magento\Framework\Setup\ModuleContextInterface;

/**
 * Class InstallSchema
 *
 * @package Eleanorsoft\NoteAndReturn\Setup
 */
class InstallSchema implements InstallSchemaInterface
{
    /**
     * install tables
     *
     * @param SchemaSetupInterface   $setup
     * @param ModuleContextInterface $context
     * @return void
     * @SuppressWarnings(PHPMD.ExcessiveMethodLength)
     */
    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $setup->startSetup();

        $setup->getConnection()->addColumn(
            $setup->getTable('sales_order'),
            'note',
            [
                'type' => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                'nullable' => true,
                'comment' => 'Note',
            ]
        );

        $setup->endSetup();
    }
}
