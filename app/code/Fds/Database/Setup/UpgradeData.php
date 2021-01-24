<?php


namespace Fds\Database\Setup;


use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\UpgradeDataInterface;

class UpgradeData implements UpgradeDataInterface
{

    /**
     * @inheritDoc
     */
    public function upgrade(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {
        $setup->startSetup();

        //comparare le versioni
        if(version_compare($context->getVersion(), '1.0.2', '<')){
            $setup->getConnection()->insert(
                $setup->getTable('affiliate_member'),
                [
                    'name'=>'Grazia Saccardo',
                    'address'=>'4 Giglio, Padova',
                    'phone_number' => '049613545',
                    'status'=>true
                ]
            );
        }


        $setup->endSetup();
    }
}
