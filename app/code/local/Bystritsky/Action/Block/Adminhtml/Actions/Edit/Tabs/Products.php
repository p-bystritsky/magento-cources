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
    {/*
        $collection = Mage::registry('current_action')->getProductsCollection();
        $this->setCollection($collection);
        return parent::_prepareCollection();*/
        $collection = Mage::getModel('catalog/product')->getCollection()
            ->addAttributeToSelect('name')
            ->addAttributeToSelect('sku')
            ->addAttributeToSelect('price')
            ->addStoreFilter($this->getRequest()->getParam('store'))
            ->joinField('position',
                'catalog/category_product',
                'position',
                'product_id=entity_id',
                'category_id=' . (int)$this->getRequest()->getParam('id', 0),
                'left');
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }

    protected function _prepareColumns()
    {

        $helper = Mage::helper('bystritsky_action');
        $this->addColumn('in_category', array(
            'header_css_class' => 'a-center',
            'type' => 'checkbox',
            'name' => 'in_category',
            'values' => Mage::registry('current_action')->getProductsCollection()->getColumnValues('product_id'),
            'align' => 'center',
            'index' => 'entity_id'
        ));

        $this->addColumn('entity_id', array(
            'header' => Mage::helper('catalog')->__('ID'),
            'sortable' => true,
            'width' => '60',
            'index' => 'entity_id'
        ));
        $this->addColumn('name', array(
            'header' => Mage::helper('catalog')->__('Name'),
            'index' => 'name'
        ));
        $this->addColumn('sku', array(
            'header' => Mage::helper('catalog')->__('SKU'),
            'width' => '80',
            'index' => 'sku'
        ));
        $this->addColumn('price', array(
            'header' => Mage::helper('catalog')->__('Price'),
            'type' => 'currency',
            'width' => '1',
            'currency_code' => (string)Mage::getStoreConfig(Mage_Directory_Model_Currency::XML_PATH_CURRENCY_BASE),
            'index' => 'price'
        ));
        $this->addColumn('position', array(
            'header' => Mage::helper('catalog')->__('Position'),
            'width' => '1',
            'type' => 'number',
            'index' => 'position',
            //'editable' => !$this->getCategory()->getProductsReadonly()
            //'renderer'  => 'adminhtml/widget_grid_column_renderer_input'
        ));

        return parent::_prepareColumns();
        return parent::_prepareColumns();
    }

    public function getGridUrl()
    {
        return $this->getUrl('*/*/products', ['_current' => true]);
    }

}