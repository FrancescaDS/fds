<?php


namespace Mastering\SampleModule\Setup;


use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\UpgradeDataInterface;

class UpgradeData implements UpgradeDataInterface
{

    public function upgrade(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {
        $setup->startSetup();

        if (version_compare($context->getVersion(), '1.0.1', '<')){
            //aggiunge questa descrizione solo per l'id = 1 vedi 'quoteInto'
            $setup->getConnection()->update(
                $setup->getTable('mastering_sample_item'),
                [
                    'description' => 'Default Descrition',
                ],
                $setup->getConnection()->quoteInto('id = ?', 1)
            );
        }

        $setup->endSetup();
    }
}
