<?php

class Bystritsky_Action_Model_Resource_Action extends Mage_Core_Model_Resource_Db_Abstract{
    protected function _construct()
    {
        $this->_init('bystritsky_action/action', 'id');
    }

    public function getProductsRelatedToAction($id, $params = null, $fields = null)
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
            'dependencies.action_id=' . $id
        );
        return $collection;
    }

}
