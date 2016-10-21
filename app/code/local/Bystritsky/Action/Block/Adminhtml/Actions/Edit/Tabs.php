<?php

class Bystritsky_Action_Block_Adminhtml_Actions_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{

    public function __construct()
    {
        $helper = Mage::helper('bystritsky_action');

        parent::__construct();
        //$this->setId('actions_tabs'); // ???
        $this->setDestElementId('edit_form');
        $this->setTitle($helper->__('Actions Information'));
        //$this->setTemplate('widget/tabshoriz.phtml');
    }


    protected function _prepareLayout()
    {
        $helper = Mage::helper('bystritsky_action');

        $this->addTab('general_section', [
            'label' => $helper->__('General Information'),
            'title' => $helper->__('General Information'),
            'content' => $this
                ->getLayout()
                ->createBlock('bystritsky_action/adminhtml_actions_edit_tabs_general')
                ->toHtml(),
        ]);
        $this->addTab('products_section', [
            'class' => 'ajax',
            'label' => $helper->__('Related Products'),
            'title' => $helper->__('Related Products'),
            'url' => $this->getUrl('*/*/products', ['_current' => true]),
        ]);
        return parent::_prepareLayout();
    }

}