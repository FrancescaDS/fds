<?php


namespace Fds\Attribute\Setup;


use Magento\Framework\Setup\InstallDataInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Eav\Setup\EavSetupFactory;

class InstallData implements InstallDataInterface
{

    protected $eavSetupFactory;

    public function __construct(EavSetupFactory $eavSetupFactory)
    {
        $this->eavSetupFactory = $eavSetupFactory;
    }

    public function install(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {
        $setup->startSetup();

        $eavSetup = $this->eavSetupFactory->create(['setup'=>$setup]);
        $eavSetup->addAttribute(
            \Magento\Catalog\Model\Product::ENTITY,
            'custom_eav',
            [
                'group'=>'Content',
                'type'=>'text',
                'backend'=>\Fds\Attribute\Model\Config\Validation::class,
                'global'=>\Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface::SCOPE_GLOBAL,
                'visibility'=>true,
                'required'=>true,
                'searchable'=>false,
                'used_in_product_listing'=>true,
                'label'=>'Custom EAV',
                'input'=>'text'
            ]
        );


        $eavSetup->addAttribute(
            \Magento\Catalog\Model\Product::ENTITY,
            'member_type',
            [
                'group'=>'Content',
                'type'=>'text',
                'global'=>\Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface::SCOPE_GLOBAL,
                'visibility'=>true,
                'required'=>false,
                'searchable'=>false,
                'used_in_product_listing'=>true,
                'label'=>'Member type',
                'input'=>'select',
                'source'=>\Fds\Attribute\Model\Config\Options::class
            ]
        );



        $setup->endSetup();
    }
}
