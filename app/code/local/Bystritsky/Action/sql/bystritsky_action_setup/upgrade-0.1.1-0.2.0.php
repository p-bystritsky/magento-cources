<?php

$installer = $this;
$installer->startSetup();
$dependencyTableName = $installer->getTable('bystritsky_action/dependency');
$actionTableName = $installer->getTable('bystritsky_action/action');
$installer->getConnection()->dropTable($dependencyTableName);

// @var $table Varien_Db_Ddl_Table
$table = $installer->getConnection()->newTable($dependencyTableName)
    ->addColumn('id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, [
        'identity' => true,
        'unsigned' => true,
        'nullable' => false,
        'primary' => true,
    ])
    ->addColumn('action_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, [
        'unsigned' => true,
        'nullable' => false
    ])
    ->addColumn('product_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, [
        'unsigned' => true,
        'nullable' => false
    ]);

$indexName = $installer->getConnection()->getIndexName(
    $dependencyTableName,
    ['action_id', 'product_id'],
    Varien_Db_Adapter_Interface::INDEX_TYPE_UNIQUE
);

$table->addIndex(
    $indexName,
    ['action_id', 'product_id'],
    ['type' => Varien_Db_Adapter_Interface::INDEX_TYPE_UNIQUE]
);

$installer->getConnection()->createTable($table);

/*
$installer->run("
CREATE TABLE `$dependencyTable`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `action_id` int(11) NOT NULL,
  `product_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `dependency` (`product_id`,`action_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

");
*/
$installer->endSetup();
