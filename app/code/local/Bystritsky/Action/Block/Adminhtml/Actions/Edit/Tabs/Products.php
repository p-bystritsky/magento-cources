<?php

class Bystritsky_Action_Block_Adminhtml_Actions_Edit_Tabs_Products extends Mage_Adminhtml_Block_Widget_Grid
{
    public function __construct()
    {
        parent::__construct();
        $this->setId('categoryProductsGrid');
        $this->setUseAjax(true);
    }

    protected function _prepareCollection()
    {
        $collection = Mage::registry('current_action')->getProductsCollection();
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }

    protected function _prepareColumns()
    {

        $helper = Mage::helper('bystritsky_action');

        $this->addColumn('ajax_grid_id', [
            'header' => $helper->__('Product ID'),
            'index' => 'product_id',
            'width' => '20',
            'type' => 'range'
        ]);
        $this->addColumn('ajax_grid_name', [
            'header' => $helper->__('Name'),
            'index' => 'product_id'
        ]);
        $this->addColumn('ajax_grid_type', [
            'header' => $helper->__('Type'),
            'index' => 'product_id'
        ]);
        $this->addColumn('ajax_grid_status', [
            'header' => $helper->__('Status'),
            'index' => 'product_id'
        ]);
        $this->addColumn('ajax_grid_visibility', [
            'header' => $helper->__('Visibility'),
            'index' => 'product_id'
        ]);
        $this->addColumn('ajax_grid_sku', [
            'header' => $helper->__('SKU'),
            'index' => 'sku'
        ]);

        return parent::_prepareColumns();
    }

    public function getGridUrl()
    {
        return $this->getUrl('*/*/products', ['_current' => true]);
    }

}