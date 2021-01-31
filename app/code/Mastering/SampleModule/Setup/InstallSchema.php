<?php


namespace Mastering\SampleModule\Setup;

use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\Db\Ddl\Table;

class InstallSchema implements InstallSchemaInterface
{

    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $setup->startSetup();

        $table = $setup->getTable('mastering_sample_item');
        $table = $setup->getConnection()
            ->newTable($table)
            ->addColumn(
                'id',
                Table::TYPE_INTEGER,
                null,
                ['identity' => true, 'nullable' => false, 'primary' => true],
                'Item ID')
            ->addColumn(
                'name',
                Table::TYPE_TEXT,
                255,
                ['nullable' => false],
                'Item Name')
            ->addIndex(
                $setup->getIdxName('mastering_sample_item', ['name']),
                ['name'])
            ->setComment('Sample Items');

        $setup->getConnection()->createTable($table);

        $setup->endSetup();
    }
}
