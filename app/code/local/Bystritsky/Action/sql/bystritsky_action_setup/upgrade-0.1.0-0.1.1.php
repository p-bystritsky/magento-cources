<?php

$installer = $this;
$installer->startSetup();
$table = $installer->getTable('bystritsky_action/action');
$installer->run("
ALTER TABLE `$table` ADD `status` INT NULL AFTER `is_active`;
");
$installer->endSetup();