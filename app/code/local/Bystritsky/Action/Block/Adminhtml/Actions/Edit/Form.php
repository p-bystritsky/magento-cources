<?php

class Bystritsky_Action_Block_Adminhtml_Actions_Edit_Form extends Mage_Adminhtml_Block_Widget_Form
{

    protected function _prepareForm()
    {
        $helper = Mage::helper('bystritsky_action');
        $model = Mage::registry('current_action');

        if (!$model->getId()) {
            $model->clearInstance();
        }


        $form = new Varien_Data_Form([
            'id' => 'edit_form',
            'action' => $this->getUrl('*/*/save', [
                'id' => $this->getRequest()->getParam('id')
            ]),
            'method' => 'post',
            'enctype' => 'multipart/form-data'
        ]);

        $this->setForm($form);

        $form->setUseContainer(true);



        return parent::_prepareForm();
    }

}
