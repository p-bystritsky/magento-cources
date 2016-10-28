<?php

class Bystritsky_Action_IndexController extends Mage_Core_Controller_Front_Action
{
    public function indexAction()
    {
        $this->loadLayout();
        $this->renderLayout();
    }

    public function viewAction()
    {
        $id = $this->getRequest()->getParam('id');
        if (empty($id)) {
            $this->_redirect('*/*/index');
        }
        $action = Mage::getModel('bystritsky_action/action')->load($id);
        if ($action->getIsActive() && $action->getStatus() == Bystritsky_Action_Model_Action::ACTING) {
            $this->loadLayout();
            $this->renderLayout();
        } else {
            $this->norouteAction();
        }
    }
}