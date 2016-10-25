<?php

class Bystritsky_Action_Block_Product extends Mage_Core_Block_Template
{
    protected $_product = null;

    function getProduct()
    {
        if (!$this->_product) {
            $this->_product = Mage::registry('product');
        }
        return $this->_product;
    }

    function getRelatedActions()
    {
        $actionIds = Mage::getModel('bystritsky_action/dependency')
            ->getCollection()
            ->addFieldToFilter('product_id', $this->getProduct()->getId())
            ->getColumnValues('action_id');
        return Mage::getModel('bystritsky_action/action')
            ->getCollection()
            ->addFieldToFilter('id', ['in' => $actionIds])
            ->addFieldToFilter('status', Bystritsky_Action_Model_Action::ACTING)
            ->addFieldToFilter('is_active', 1);
    }
}