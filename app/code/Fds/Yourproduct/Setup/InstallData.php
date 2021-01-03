<?php

/**
 * Fds_Yourproduct
 * Fds - fdallserra 2018
 * Install module
 * Creates custom default attributes and questions
 */

namespace Fds\Yourproduct\Setup;

use Magento\Eav\Setup\EavSetup;
use Magento\Eav\Setup\EavSetupFactory;
use Magento\Framework\Setup\InstallDataInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\DB\Ddl\Table;

class InstallData implements InstallDataInterface
{

    private $eavSetupFactory;
    protected $_eavAttribute;

    public function __construct(
        \Magento\Eav\Model\ResourceModel\Entity\Attribute $eavAttribute,
        EavSetupFactory $eavSetupFactory
    )
    {
        $this->eavSetupFactory = $eavSetupFactory;
        $this->_eavAttribute = $eavAttribute;
    }


    public function install(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {
        $setup->startSetup();

        //ADD DEFAULT ATTRIBUTE
        $attributes = [
            ['fdsyour_women', 'Woman', 1],
            ['fdsyour_men', 'Man', 1],
            ['fdsyour_under30', 'Under 30 years', 2],
            ['fdsyour_3040', 'Between 30 and 40 years', 2],
            ['fdsyour_over40', 'Over 40 years', 2],
            ['fdsyour_skin', 'Skin', 3],
            ['fdsyour_nails', 'Nails', 3],
            ['fdsyour_hair', 'Hair', 3],
            ['fdsyour_lips', 'Lips', 3],
            ['fdsyour_muscles', 'Muscles and joints', 3]
        ];
        $this->addAttributs($attributes, $setup);


        //ADD DEFAULT QUESTIONS
        $data = [
            [   'question' => 'Select your gender',
                'question_order' => 1,
                'multi_select' => 0,
                'status' => 1],
            [   'question' => 'Select your age',
                'question_order' => 2,
                'multi_select' => 0,
                'status' => 1],
            [   'question' => 'Looking for a product for',
                'question_order' => 3,
                'multi_select' => 1,
                'status' => 1]
        ];
        foreach ($data as $bind) {
            $setup->getConnection()
                ->insertForce($setup->getTable('fdsyour_question'), $bind);
        }

        //ADD DEFAULT QUESTIONS-ATTRIBUTES JOINS
        $dataJoin = array();
        foreach ($attributes as $i => $attribute) {
            $code = $attribute[0];
            $questionId = $attribute[2];
            //get the attribute_id from the eav_attribute table
            $attributeId = $this->_eavAttribute->getIdByCode('catalog_product', $code);

            if ($attributeId > 0){
                $dataJoin[$i]['question_id'] = $questionId;
                $dataJoin[$i]['attribute_id'] = $attributeId;
            }
        }
        foreach ($dataJoin as $bind) {
            $setup->getConnection()
                ->insertForce($setup->getTable('fdsyour_question_attribute'), $bind);
        }


        //ADD DEFAULT QUESTIONS-STORES JOINS
        //NON HA SENSO
      /*  $questionStore = array();
        $questionStore[0]['question_id'] = 1;
        $questionStore[0]['store_id'] = 2;
        $questionStore[0]['question'] = 1;
        $questionStore[1]['question_id'] = 2;
        $questionStore[1]['store_id'] = 2;
        $questionStore[2]['question_id'] = 3;
        $questionStore[2]['store_id'] = 2;

        foreach ($questionStore as $bind) {
            $setup->getConnection()
                ->insertForce($setup->getTable('fdsyour_question_store_label'), $bind);
        }
*/

        $setup->endSetup();
    }


    public function addAttributs($attributes, $setup)
    {
        foreach ($attributes as $attribute){
            $code = $attribute[0];
            $label = $attribute[1];

            $eavSetup = $this->eavSetupFactory->create(['setup' => $setup]);
            $eavSetup->addAttribute(
                \Magento\Catalog\Model\Product::ENTITY,
                $code,
                [
                    'group' => 'Fds Yourproduct',
                    'type' => 'int',
                    'backend' => '',
                    'frontend' => '',
                    'label' => $label,
                    'input' => 'boolean',
                    'class' => '',
                    'source' => 'Magento\Eav\Model\Entity\Attribute\Source\Boolean',
                    'global' => \Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface::SCOPE_GLOBAL,
                    'visible' => true,
                    'required' => false,
                    'user_defined' => false,
                    'default' => '0',
                    'searchable' => false,
                    'filterable' => false,
                    'comparable' => false,
                    'visible_on_front' => false,
                    'used_in_product_listing' => true,
                    'unique' => false,
                    'apply_to' => 'simple'
                ]
            );
        }
    }

}
