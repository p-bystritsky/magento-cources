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
    public function getProductsRelatedToAtion($action, $params = null, $fields = null) {
        $productIds = $action->getProductsCollection()->getColumnValues('product_id');
        $products = Mage::getModel('catalog/product')->getCollection();
        $products->addAttributeToFilter('entity_id', ['in' => $productIds]);
        if ($params) {
            foreach ($params as $key => $value) {
                $products->addFieldToFilter($key, $value);
            }
        }
        if ($fields) {
            foreach ($fields as $field) {
                $products->addAttributeToSelect($field);
            }
        }
        return $products;
    }

}
