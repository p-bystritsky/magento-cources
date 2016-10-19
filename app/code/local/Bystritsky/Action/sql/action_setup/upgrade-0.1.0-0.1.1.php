<?php

$installer = $this;
$installer->startSetup();
$installer->run("
ALTER TABLE `{$installer->getTable('bystritsky_action/action')}` ADD `status` INT NULL AFTER `is_active`;
");
$installer->endSetup();