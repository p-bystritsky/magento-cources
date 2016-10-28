<?php

class Bystritsky_Action_Block_View extends Mage_Catalog_Block_Product_Abstract //Mage_Core_Block_Template
{
    public function getAction()
    {
        $id = $this->getRequest()->getParam('id');
        $actions = Mage::getModel('bystritsky_action/action');
        $action = $actions->load($id);
        return $action;
    }

    /*
        // old version, not used anymore
        public function _getProductsRelatedToAction($action, $params = null, $fields = null)
        {
            $productIds = $action->getProductIdCollection();
            $websiteId = Mage::app()->getWebsite()->getId();
            $products = Mage::getModel('catalog/product')
                ->getCollection()
                ->addWebsiteFilter([$websiteId]);
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
    */
    public function getProductsRelatedToAction($action, $params = null, $fields = null)
    {
        return $action->getProductsRelatedToAction($params, $fields);
    }
}
