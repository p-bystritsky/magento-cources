<?php

class Bystritsky_Action_IndexController extends Mage_Core_Controller_Front_Action
{
    public function indexAction()
    {
        $this->loadLayout();
        $this->renderLayout();
    }

    public function showAction()
    {
        $params = $this->getRequest()->getParams();
        $action = Mage::getModel('bystritsky_action/action');
        echo("Loaded model " . get_class($action));
        echo("<br>Loading the action with an ID of " . $params['id']);
        $action->load($params['id']);
        $data = $action->getData();
        var_dump($data);
    }

    public function newAction()
    {
        $blogpost = Mage::getModel('bystritsky_action/action');
        $blogpost->setTitle('Code Post!');
        $blogpost->setPost('This post was created from code!');
        $blogpost->save();
        echo 'post with ID ' . $blogpost->getId() . ' created';
    }

    public function showAllAction()
    {
        $actions = Mage::getModel('bystritsky_action/action')->getCollection();
        foreach ($actions as $action) {
            echo '<h3>' . $action->getName() . '</h3>';
            echo nl2br($action->getDescription());
        }
    }
}