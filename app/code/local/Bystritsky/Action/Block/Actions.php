<?php

class Bystritsky_Action_Block_Actions extends Mage_Core_Block_Template
{

    public function getActionsCollection()
    {
        /** @var Bystritsky_Action_Model_Resource_Action_Collection $actions */
        $actions = Mage::getModel('bystritsky_action/action')->getCollection();
        $actions->addFilter('is_active', '1')->setOrder('start_datetime', 'DESC');
        return $actions;
    }
}
