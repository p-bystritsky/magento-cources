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
        $this->loadLayout();
        $this->renderLayout();
    }
}