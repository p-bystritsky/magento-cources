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

    public function getProductsRelatedToAction($action, $params = null, $fields = null)
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

    /*
    SELECT entity_id
    FROM magento.catalog_product_entity
    INNER JOIN magento.bystritsky_action_dependencies
    ON magento.catalog_product_entity.entity_id = magento.bystritsky_action_dependencies.product_id
    INNER JOIN magento.bystritsky_action_actions
    ON magento.bystritsky_action_dependencies.action_id = magento.bystritsky_action_actions.id
    WHERE magento.bystritsky_action_actions.id = 32
    */
    /*
    SELECT `e`.*, `e`.`entity_id`
    FROM `catalog_product_entity` AS `e`
    INNER JOIN `bystritsky_action_dependencies` AS `dependencies`
    ON e.entity_id=dependencies.product_id
    INNER JOIN `bystritsky_action_actions` AS `actions`
    ON dependencies.action_id=actions.id
    WHERE (actions.id=1)
    */

    public function _getProductsRelatedToAction($action, $params = null, $fields = null)
    {
        $websiteId = Mage::app()->getWebsite()->getId();
        /* @var $collection Mage_Catalog_Model_Resource_Product_Collection */
        $collection = Mage::getModel('catalog/product')
            ->getCollection()
            ->addWebsiteFilter([$websiteId])
            ->addAttributeToSelect('name', 'sku', 'image', 'price');
        $collection
            ->getSelect()
            ->joinInner(
                ['dependencies' => 'bystritsky_action_dependencies'],
                'dependencies.product_id=e.entity_id'
            //['e.name', 'e.sku', 'e.image', 'e.price']
            )
            ->joinInner(
                ['actions' => 'bystritsky_action_actions'],
                'dependencies.action_id=actions.id',
                []
            )->where(
                'actions.id=?', (int)$action->getId()
            );

        /*
        $products = Mage::getModel('bystritsky_action/action')
            ->getCollection()
            ->join(
                ['dependency' => 'bystritsky_action/dependency'],
                'dependency.action_id=main_table.id',
                ['dependency.product_id']
            )
            ->join(
                ['product' => 'catalog/product'],
                'dependency.product_id=product.entity_id'
            )
            ->getColumnValues('entity_id');
        */
        return $collection;
    }
}
