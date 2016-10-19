<?php

$installer = $this;
$installer->startSetup();
$installer->run("
CREATE TABLE `{$installer->getTable('bystritsky_action/dependency')}`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `action_id` int(11) NOT NULL,
  `product_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `dependency` (`product_id`,`action_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE `{$installer->getTable('bystritsky_action/dependency')}`
  ADD CONSTRAINT `bystritsky_action_dependencies_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `catalog_product_entity` (`entity_id`),
  ADD CONSTRAINT `bystritsky_action_dependencies_ibfk_1` FOREIGN KEY (`action_id`) REFERENCES `bystritsky_action_actions` (`id`);

");
$installer->endSetup();
