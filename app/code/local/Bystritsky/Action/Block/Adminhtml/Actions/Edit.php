<?php

class Bystritsky_Action_Block_Adminhtml_Actions_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{

    protected function _construct()
    {
        $this->_blockGroup = 'bystritsky_action';
        $this->_controller = 'adminhtml_actions';
    }

    public function getHeaderText()
    {
        $helper = Mage::helper('bystritsky_action');
        $model = Mage::registry('current_action');

        if ($model->getId()) {
            return $helper->__("Edit Action item '%s'", $this->escapeHtml($model->getName()));
        } else {
            return $helper->__("Add Action item");
        }
    }

}