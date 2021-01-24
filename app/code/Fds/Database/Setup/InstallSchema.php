<?php


namespace Fds\Database\Setup;


use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Db\Ddl\Table;

class InstallSchema implements InstallSchemaInterface
{
//this script will run every time is installed this module
    /**
     * @inheritDoc
     */
    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $setup->startSetup();

        //creo tabella per affiliate member
        //struttura della tabella

        $table = $setup->getTable('affiliate_member');
        $table = $setup->getConnection()
            ->newTable($table)
            ->addColumn(
                'entity_id',
                Table::TYPE_INTEGER,
                null,
                ['identity'=>true, 'nullable'=>false, 'primary'=>true],
                'MEMBER ID'
            )
            ->addColumn(
                'name',
                Table::TYPE_TEXT,
                255,
                ['nullable'=>false],
                'NAME OF MEMBER'
            )->addColumn(
                'address',
                Table::TYPE_TEXT,
                255,
                ['nullable'=>false],
                'ADDRESS OF MEMBER'
            )
            ->addColumn(
                'status',
                Table::TYPE_BOOLEAN,
                10,
                ['nullable'=>false, 'default'=>false],
                'STATUS'
            )
            ->addColumn(
                'created_at',
                Table::TYPE_TIMESTAMP,
                null,
                ['nullable'=>false, 'default'=>Table::TIMESTAMP_INIT],
                'TIME CREATED'
            )
            ->addColumn(
                'updated_at',
                Table::TYPE_TIMESTAMP,
                null,
                ['nullable'=>false, 'default'=>Table::TIMESTAMP_INIT_UPDATE],
                'TIME FOR UPDATE'
            )
            ->setComment('Question Table')
            ->setOption('type', 'InnoDB')
            ->setOption('charset', 'utf8');

        $setup->getConnection()->createTable($table);

        $setup->endSetup();
    }
}
