<?php

class Bystritsky_Action_Block_Adminhtml_Actions_Edit_Tabs_Products extends Mage_Adminhtml_Block_Widget_Grid
{

    public function __construct()
    {
        parent::__construct();
        $model = Mage::registry('current_action');
        // Used for AJAX loading
        $this->setSaveParametersInSession(true);
        $this->setUseAjax(true);
    }

    protected function _prepareCollection()
    {
        $collection = Mage::getModel('catalog/product')->getCollection()
            ->addAttributeToSelect('name')
            ->addAttributeToSelect('visibility')
            ->addAttributeToSelect('type_id')
            ->addAttributeToSelect('sku')
            ->addStoreFilter($this->getRequest()->getParam('store'))
            ->joinField('position',
                'catalog/category_product',
                'position',
                'product_id=entity_id',
                'category_id='.(int) $this->getRequest()->getParam('id', 0),
                'left')->joinAttribute('visibility', 'catalog_product/visibility', 'entity_id', null, 'inner', 1);
        $this->setCollection($collection);

      return parent::_prepareCollection();
    }

    protected function _prepareColumns()
    {

        $this->addColumn('in_action', [
            'type'      => 'checkbox',
            'header'    => Mage::helper('catalog')->__('In Action'),
            'values'    => $this->_getSelectedProducts(),
            'index'     => 'entity_id'
        ]);

        $this->addColumn('entity_id', [
            'header'    => Mage::helper('catalog')->__('ID'),
            'sortable'  => true,
            'width'     => '60',
            'index'     => 'entity_id'
        ]);
        $this->addColumn('product_name', [
            'header'    => Mage::helper('catalog')->__('Name'),
            'index'     => 'name'
        ]);
        $this->addColumn('type_id', [
            'header'    => Mage::helper('catalog')->__('Type'),
            'index'     => 'type_id'
        ]);
        $this->addColumn('visibility', [
            'header'    => Mage::helper('catalog')->__('Visibility'),
            'index'     => 'visibility'
        ]);
        $this->addColumn('sku', [
            'header'    => Mage::helper('catalog')->__('SKU'),
            'width'     => '80',
            'index'     => 'sku'
        ]);
        return parent::_prepareColumns();
    }

    public function getGridUrl()
    {
        return $this->getUrl('*/*/grid', ['_current'=>true]);
    }

    protected function _getSelectedProducts()
    {
        $action = Mage::registry('current_action');
        $products = Mage::getModel('bystritsky_action/action')
            ->getCollection()
            ->addFieldToFilter('action_id', $action->getID());
        return $products;
    }

}