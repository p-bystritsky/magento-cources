<?php

$installer = $this;
$installer->startSetup();
$tableName = $installer->getTable('bystritsky_action/action');

$installer->getConnection()->addColumn($tableName, 'status', [
    'type'  => Varien_Db_Ddl_Table::TYPE_INTEGER,
    'null' => true,
    'comment' => 'Calculates in runtime'
]);

$installer->endSetup();