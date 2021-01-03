<?php

/**
 * Fds_Yourproduct
 * Fds - fdallserra 2018
 * Install module
 * Declares and creates custom tables:
 *      fdsyour_question, fdsyour_question_attribute
 */

namespace Fds\Yourproduct\Setup;

use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\DB\Ddl\Table;
use Magento\Framework\DB\Adapter\AdapterInterface;

class InstallSchema implements InstallSchemaInterface
{
    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $installer = $setup;
        $installer->startSetup();

        $this->createQuestionTable($installer);

        //create join table between Question-Attribute
        $this->createJoinTable($installer,
                $newTable = 'fdsyour_question_attribute',
                $referenceTable1 = 'fdsyour_question',
                $referenceColumn1 = 'question_id',
                $columnNew1 = 'question_id',
                $referenceTable2 = 'eav_attribute',
                $referenceColumn2 = 'attribute_id',
                $columnNew2 = 'attribute_id'
            );


        //create join table between Question-Store with text for different stores
        $this->createJoinQuestionStoreLabel($installer);

        //create jointable between Attributes-Users (code-iduser) >>> result of personal tests

        $installer->endSetup();
    }


    public function createQuestionTable($installer)
    {
        $tableName = "fdsyour_question";

        $table = $installer->getTable($tableName);
        if ($installer->getConnection()->isTableExists($table) != true) {
            $table = $installer->getConnection()
                ->newTable($table)
                ->addColumn(
                    'question_id',
                    Table::TYPE_SMALLINT,
                    null,
                    [
                        'identity' => true,
                        'unsigned' => true,
                        'nullable' => false,
                        'primary' => true
                    ],
                    'Question ID'
                )
                ->addColumn(
                    'question',
                    Table::TYPE_TEXT,
                    null,
                    ['nullable' => false, 'default' => ''],
                    'Question'
                )
                ->addColumn(
                    'multi_select',
                    Table::TYPE_SMALLINT,
                    null,
                    ['nullable' => false, 'default' => '0'],
                    'Multi select'
                )
                ->addColumn(
                    'question_order',
                    Table::TYPE_SMALLINT,
                    null,
                    [
                        'nullable' => false, 'default' => '0'
                    ],
                    'Order'
                )
                ->addColumn(
                    'status',
                    Table::TYPE_SMALLINT,
                    null,
                    ['nullable' => false, 'default' => '0'],
                    'Status'
                )
                ->setComment('Question Table')
                ->setOption('type', 'InnoDB')
                ->setOption('charset', 'utf8');
            $installer->getConnection()->createTable($table);
        }
    }


    public function createJoinTable($installer,
                                    $newTable,
                                    $referenceTable1,
                                    $referenceColumn1,
                                    $columnNew1,
                                    $referenceTable2,
                                    $referenceColumn2,
                                    $columnNew2)
    {
        $table = $installer->getTable($newTable);
        if ($installer->getConnection()->isTableExists($table) != true) {
            $table = $installer->getConnection()
                ->newTable($table)
                ->addColumn(
                    'id',
                    Table::TYPE_SMALLINT,
                    null,
                    [
                        'identity' => true,
                        'unsigned' => true,
                        'nullable' => false,
                        'primary' => true
                    ],
                    'ID'
                )
                ->addColumn(
                    $columnNew1,
                    Table::TYPE_SMALLINT,
                    null,
                    ['unsigned'=>true, 'nullable'=>false, 'default' => '0'],
                    $columnNew1
                )
                ->addColumn(
                    $columnNew2,
                    Table::TYPE_SMALLINT,
                    null,
                    ['unsigned'=>true, 'nullable'=>false, 'default' => '0'],
                    $columnNew2
                )
                ->addIndex(
                    $installer->getIdxName(
                        $newTable,
                        [$columnNew1,$columnNew2],
                        AdapterInterface::INDEX_TYPE_UNIQUE
                    ),
                    [$columnNew1,$columnNew2],
                    AdapterInterface::INDEX_TYPE_UNIQUE
                )
                ->addForeignKey(
                    $installer->getFkName(
                        $newTable,   // New table
                        $columnNew1, // Column in New Table
                        $referenceTable1, // Reference Table
                        $referenceColumn1 // Column in Reference table
                    ),
                    $columnNew1, // New table column
                    $installer->getTable($referenceTable1), // Reference Table
                    $referenceColumn1, // Reference Table Column
                    // When the parent is deleted, delete the row with foreign key
                    Table::ACTION_CASCADE
                )
                ->addForeignKey(
                    $installer->getFkName(
                        $newTable,   // New table
                        $columnNew2, // Column in New Table
                        $referenceTable2, // Reference Table
                        $referenceColumn2 // Column in Reference table
                    ),
                    $columnNew2, // New table column
                    $installer->getTable($referenceTable2), // Reference Table
                    $referenceColumn2, // Reference Table Column
                    // When the parent is deleted, delete the row with foreign key
                    Table::ACTION_CASCADE
                )
                ->setComment($newTable . ' Table')
                ->setOption('type', 'InnoDB')
                ->setOption('charset', 'utf8');
            $installer->getConnection()->createTable($table);
        }
    }



    public function createJoinQuestionStoreLabel($installer)
    {
        //create join table between Questions-Stores for different translations (question_id-store_id)
        //fdsyour_question  > id
        //store > store_id
        $tableName = 'fdsyour_question_store_label';

        $table = $installer->getTable($tableName);
        if ($installer->getConnection()->isTableExists($table) != true) {
            $table = $installer->getConnection()
                ->newTable($table)
                ->addColumn(
                    'question_label_id',
                    Table::TYPE_SMALLINT,
                    null,
                    [
                        'identity' => true,
                        'unsigned' => true,
                        'nullable' => false,
                        'primary' => true
                    ],
                    'ID'
                )
                ->addColumn(
                    'question_id',
                    Table::TYPE_SMALLINT,
                    null,
                    ['unsigned'=>true, 'nullable'=>false, 'default' => '0'],
                    'Question Id'
                )
                ->addColumn(
                    'store_id',
                    Table::TYPE_SMALLINT,
                    null,
                    ['unsigned'=>true, 'nullable'=>false, 'default' => '0'],
                    'Store Id'
                )
                ->addColumn(
                    'question',
                    Table::TYPE_TEXT,
                    null,
                    ['nullable' => false, 'default' => ''],
                    'Question'
                )
                ->addIndex(
                    $installer->getIdxName(
                        $tableName,
                        ['question_id','store_id'],
                        AdapterInterface::INDEX_TYPE_UNIQUE
                    ),
                    ['question_id','store_id'],
                    AdapterInterface::INDEX_TYPE_UNIQUE
                )
                ->addForeignKey(
                    $installer->getFkName(
                        $tableName,   // New table
                        'question_id', // Column in New Table
                        'fdsyour_question', // Reference Table
                        'question_id' // Column in Reference table
                    ),
                    'question_id', // New table column
                    $installer->getTable('fdsyour_question'), // Reference Table
                    'question_id', // Reference Table Column
                    // When the parent is deleted, delete the row with foreign key
                    Table::ACTION_CASCADE
                )
                ->addForeignKey(
                    $installer->getFkName(
                        $tableName,   // New table
                        'store_id', // Column in New Table
                        'store', // Reference Table
                        'store_id' // Column in Reference table
                    ),
                    'store_id', // New table column
                    $installer->getTable('store'), // Reference Table
                    'store_id', // Reference Table Column
                    // When the parent is deleted, delete the row with foreign key
                    Table::ACTION_CASCADE
                )

                ->setComment($tableName . ' Table')
                ->setOption('type', 'InnoDB')
                ->setOption('charset', 'utf8');
            $installer->getConnection()->createTable($table);
        }
    }

}
