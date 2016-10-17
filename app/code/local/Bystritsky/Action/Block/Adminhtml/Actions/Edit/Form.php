<?php

class Bystritsky_Action_Block_Adminhtml_Actions_Edit_Form extends Mage_Adminhtml_Block_Widget_Form
{

    protected function _prepareForm()
    {
        $helper = Mage::helper('bystritsky_action');
        $model = Mage::registry('current_action');
        $format = Mage::app()->getLocale()->getDateTimeFormat(Mage_Core_Model_Locale::FORMAT_TYPE_SHORT);

        $form = new Varien_Data_Form([
            'id' => 'edit_form',
            'action' => $this->getUrl('*/*/save', [
                'id' => $this->getRequest()->getParam('id')
            ]),
            'method' => 'post',
            'enctype' => 'multipart/form-data'
        ]);

        $this->setForm($form);

        $fieldset = $form->addFieldset('action_form', ['legend' => $helper->__('Action Information')]);

        $fieldset->addField('name', 'text', [
            'label' => $helper->__('Name'),
            'required' => true,
            'name' => 'name',
        ]);

        $fieldset->addField('is_active', 'select', [
            'label' => $helper->__('Active'),
            'required' => true,
            'name' => 'is_active',
            'values' => ['no', 'yes']
        ]);

        $fieldset->addField('short_description', 'text', [
            'label' => $helper->__('Short Description'),
            'required' => true,
            'name' => 'short_description',
        ]);

        $fieldset->addField('description', 'textarea', [
            'label' => $helper->__('Description'),
            'required' => true,
            'name' => 'description'
        ]);

        $fieldset->addField('image', 'text', [
            'label' => $helper->__('Image'),
            'required' => true,
            'name' => 'image',
        ]);

        $fieldset->addField('create_datetime', 'date', [
            'time' => true,
            'format' => $format,
            //'inputFormat' => 'Y-m-d H:i:s',
            'image' => $this->getSkinUrl('images/grid-cal.gif'),
            'label' => $helper->__('Created'),
            'required' => true,
            'name' => 'create_datetime'
        ]);

        $fieldset->addField('start_datetime', 'date', [
            'time' => true,
            'format' => $format,
            'image' => $this->getSkinUrl('images/grid-cal.gif'),
            'label' => $helper->__('Start'),
            'required' => true,
            'name' => 'start_datetime'
        ]);

        $fieldset->addField('end_datetime', 'date', [
            'time' => true,
            'format' => $format,
            'image' => $this->getSkinUrl('images/grid-cal.gif'),
            'label' => $helper->__('End'),
            'required' => false,
            'name' => 'end_datetime'
        ]);


        $form->setUseContainer(true);

        if ($data = Mage::getSingleton('adminhtml/session')->getFormData()) {
            $form->setValues($data);
        } else {
            $form->setValues($model->getData());
            /*
            $form->addValues(
                [
                    'create_datetime'=>
                        Mage::getModel('core/date')->date($format)
                ]
            );
            */
        }

        return parent::_prepareForm();
    }

}
