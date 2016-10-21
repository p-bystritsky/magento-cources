<?php

class Bystritsky_Action_Block_Adminhtml_Actions_Edit_Tabs_Products extends Mage_Adminhtml_Block_Widget_Grid
{

    private $_allProductId;

    public function getAllProductId()
    {
        return $this->_allProductId;
    }

    public function setAllProductId($allProductId)
    {
        $this->_allProductId = $allProductId;
    }

    public function __construct()
    {
        parent::__construct();
        $this->setAllProductId(Mage::registry('current_action')->getProductsCollection()->getColumnValues('product_id'));
        if (!empty($this->getAllProductId())) {
            $this->setDefaultFilter(['ajax_in_action' => 1]);
        } else {
            $this->setDefaultFilter(['ajax_in_action' => 0]);
        }
        $this->setSaveParametersInSession(false);
        $this->setId('categoryProductsGrid');
        $this->setUseAjax(true);
    }

    protected function _prepareCollection()
    {
        //id, name, type, status, visibility, sku
        $collection = Mage::getModel('catalog/product')->getCollection()
            ->addAttributeToSelect('name')
            ->addAttributeToSelect('type')
            ->addAttributeToSelect('status')
            ->addAttributeToSelect('visibility')
            ->addAttributeToSelect('sku');
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }

    protected function _prepareColumns()
    {

        $helper = Mage::helper('bystritsky_action');

        $this->addColumn('ajax_in_action', [
            'align' => 'center',
            'header_css_class' => 'a-center',
            'index' => 'entity_id',
            'type' => 'checkbox',
            // getSelectedProducts() here will cause problems!
            'values' => $this->getAllProductId()
        ]);

        $this->addColumn('ajax_entity_id', [
            'header' => Mage::helper('catalog')->__('ID'),
            'sortable' => true,
            'width' => '60',
            'index' => 'entity_id',
            'type' => 'number'
        ]);
        $this->addColumn('ajax_name', [
            'header' => Mage::helper('catalog')->__('Name'),
            'index' => 'name'
        ]);
        $this->addColumn('ajax_type', [
            'header' => Mage::helper('catalog')->__('Type'),
            'width' => '150px',
            'index' => 'type_id',
            'type' => 'options',
            'options' => Mage::getSingleton('catalog/product_type')->getOptionArray(),
        ]);
        $this->addColumn('ajax_status', [
            'header' => Mage::helper('catalog')->__('Status'),
            'width' => '70px',
            'index' => 'status',
            'type' => 'options',
            'options' => Mage::getSingleton('catalog/product_status')->getOptionArray(),

        ]);
        $this->addColumn('ajax_visibility', [
            'header' => Mage::helper('catalog')->__('Visibility'),
            'width' => '150px',
            'index' => 'visibility',
            'type' => 'options',
            'options' => Mage::getModel('catalog/product_visibility')->getOptionArray(),
        ]);
        $this->addColumn('ajax_sku', [
            'header' => Mage::helper('catalog')->__('SKU'),
            'index' => 'sku',
            'width' => '60px'
        ]);


        return parent::_prepareColumns();
    }

    protected function _addColumnFilterToCollection($column)
    {
        if ($column->getId() == 'ajax_in_action') {
            $collection = $this->getCollection();
            $selectedProducts = $this->getSelectedProducts();
            if ($column->getFilter()->getValue()) {
                $collection->addFieldToFilter('entity_id', ['in' => $selectedProducts]);
            } elseif (!empty($selectedProducts)) {
                $collection->addFieldToFilter('entity_id', ['nin' => $selectedProducts]);
            }
        } else {
            parent::_addColumnFilterToCollection($column);
        }
        return $this;
    }

    public function getGridUrl()
    {
        return $this->getUrl('*/*/products', ['_current' => true, 'grid_only' => 1]);
    }

    public function getSelectedProducts()
    {
        if (!isset($this->_data['selected_products'])) {
            $selectedProducts = Mage::app()->getRequest()->getParam('selected_products', null);
            if (is_null($selectedProducts) || !is_array($selectedProducts)) {
                $category = Mage::registry('current_action');
                $selectedProducts = $category
                    ->getProductsCollection()
                    ->getColumnValues('product_id');
            }
            $this->_data['selected_products'] = $selectedProducts;
        }
        return $this->_data['selected_products'];

    }

}