<?php


namespace Mastering\SampleModule\Setup;


use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\Setup\UpgradeSchemaInterface;
use Magento\Framework\Db\Ddl\Table;

class UpgradeSchema implements UpgradeSchemaInterface
{
    /**
     * @param SchemaSetupInterface $setup
     * @param ModuleContextInterface $context
     */
    public function upgrade(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $setup->startSetup();

        //se ci sono piu' apgrade dello stesso modello bisogna mettere queste condizioni delle versioni
        if (version_compare($context->getVersion(), '1.0.1', '<')){
            //aggiungo una colonna a una tabella gia' esistente
            $setup->getConnection()
                ->addColumn(
                    $setup->getTable('mastering_sample_item'),
                    'description',
                    [
                        'type' => Table::TYPE_TEXT,
                        'nullable' => true,
                        'comment' => 'Item Description'
                    ]
                );
        }

        if (version_compare($context->getVersion(), '1.0.2', '<')){
            //aggiungo una colonna a una tabella gia' esistente
            $setup->getConnection()
                ->addColumn(
                    $setup->getTable('sales_order_grid'),
                    'base_tax_amount',
                    [
                        'type' => Table::TYPE_DECIMAL,
                        'comment' => 'Base Tax Amount'
                    ]
                );
        }


        $setup->endSetup();
    }
}
