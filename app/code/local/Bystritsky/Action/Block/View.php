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

    // old version, not used anymore
    public function _getProductsRelatedToAction($action, $params = null, $fields = null)
    {
        $productIds = $action->getProductsCollection()->getColumnValues('product_id');
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

    public function getProductsRelatedToAction($action, $params = null, $fields = null)
    {
        /* @var $collection Mage_Catalog_Model_Resource_Product_Collection */
        $collection = Mage::getModel('catalog/product')->getCollection();
        $websiteId = Mage::app()->getWebsite()->getId();
        $collection->addWebsiteFilter([$websiteId]);
        if ($params) {
            foreach ($params as $key => $value) {
                $collection->addAttributeToFilter($key, $value);
            }
        }
        if ($fields) {
                $collection->addAttributeToSelect($fields);

        }
        $collection->joinTable(
            ['dependencies' => 'bystritsky_action_dependencies'],
            'product_id=entity_id',
            ['*' => 'e.*'],
            'dependencies.action_id=' . $action->getId()
        );
        return $collection;
    }
}
