<?php

class Bystritsky_Action_Model_Resource_Dependency_Collection extends Mage_Core_Model_Resource_Db_Collection_Abstract {
    protected function _construct()
    {
        $this->_init('bystritsky_action/dependency');
    }
}