<?php


namespace Fds\Database\Setup;


use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\Setup\UpgradeSchemaInterface;
use Magento\Framework\Db\Ddl\Table;


class UpgradeSchema implements UpgradeSchemaInterface
{

    /**
     * @inheritDoc
     */
    public function upgrade(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $setup->startSetup();

        //comparare le versioni
        if(version_compare($context->getVersion(), '1.0.1', '<')){
            //aggiungere una colonna alla tabella creata durante l'installazione

            $setup->getConnection()->addColumn(
                $setup->getTable('affiliate_member'),
                'phone_number',
                [
                    'nullable'=>false,
                    'type'=>Table::TYPE_TEXT,
                    'comment'=>'PHONE NUMBER OF MEMBER'
                ]
            );

        }

        $setup->endSetup();
    }
}
