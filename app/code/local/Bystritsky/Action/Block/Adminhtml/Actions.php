<?php

class Bystritsky_Action_Block_Adminhtml_Actions extends Mage_Adminhtml_Block_Widget_Grid_Container
{
    protected function _construct()
    {
        parent::_construct();

        $helper = Mage::helper('bystritsky_action');
        $this->_blockGroup = 'bystritsky_action';
        $this->_controller = 'adminhtml_actions';

        $this->_headerText = $helper->__('Actions Management');
        $this->_addButtonLabel = $helper->__('Add Action');
    }

/*
    public function _toHtml()
    {
        return '<h1>Actions Module: Admin section</h1>';
    }
*/

}