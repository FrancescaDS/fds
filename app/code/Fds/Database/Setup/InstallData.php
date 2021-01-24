<?php


namespace Fds\Database\Setup;


use Magento\Framework\Setup\InstallDataInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;

class InstallData implements InstallDataInterface
{

    public function install(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {
        $setup->startSetup();

        //Inserisco dati nella tabella creata durante l'installazione

        $setup->getConnection()->insert(
            $setup->getTable('affiliate_member'),
            [
                'name'=>'Francesca Dalla Serra',
                'address'=>'34 Lomazzo, Milano',
                'status'=>true
            ]
        );

        $setup->getConnection()->insert(
            $setup->getTable('affiliate_member'),
            [
                'name'=>'Alessandra Alari',
                'address'=>'4 Lofting Road, London'
            ]
        );


        $setup->endSetup();
    }
}
