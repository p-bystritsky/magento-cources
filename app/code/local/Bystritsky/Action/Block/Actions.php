<?php

class Bystritsky_Action_Block_Actions extends Mage_Core_Block_Template
{

    public function getActionsCollection()
    {
        /** @var Bystritsky_Action_Model_Resource_Action_Collection $actions */

        $actions = Mage::getModel('bystritsky_action/action')->getCollection();
        $actions
            ->addFieldToFilter('is_active', '1')
            ->addFieldToFilter('start_datetime', ['lt' => Mage::getModel('core/date')->gmtDate()])
            ->addFieldToFilter('end_datetime', [['gt' => Mage::getModel('core/date')->gmtDate()], 'Null'])
            ->setOrder('start_datetime', 'DESC');
        Mage::log((string) $actions->getSelect());
        return $actions;
    }
}
