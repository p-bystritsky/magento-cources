<?php

class Bystritsky_Action_Block_View extends Mage_Core_Block_Template
{
    public function getAction()
    {
        $id = $this->getRequest()->getParam('id');
        $actions = Mage::getModel('bystritsky_action/action');
        $action = $actions->load($id);
        if ($action->getIsActive() && $action->getStatus() == Bystritsky_Action_Model_Action::ACTING) {
            return $action;
        } else {
            Mage::app()->getResponse()->setRedirect('/no-route.html');
        }
    }
}
