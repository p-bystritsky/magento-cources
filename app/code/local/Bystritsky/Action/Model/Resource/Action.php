<?php

class Bystritsky_Action_Model_Resource_Action extends Mage_Core_Model_Resource_Db_Abstract{
    protected function _construct()
    {
        $this->_init('bystritsky_action/action', 'id');
    }
}
