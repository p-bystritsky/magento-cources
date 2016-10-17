<?php

class Bystritsky_Action_Adminhtml_ActionsController extends Mage_Adminhtml_Controller_Action
{

    public function indexAction()
    {
        $this->loadLayout();
        $this->_setActiveMenu('bystritsky_action');

        $contentBlock = $this->getLayout()->createBlock('bystritsky_action/adminhtml_actions');
        $this->_addContent($contentBlock);
        $this->renderLayout();
    }

    public function newAction()
    {
        $this->_forward('edit');
    }

    public function editAction()
    {
        $id = (int)$this->getRequest()->getParam('id');
        Mage::register('current_action', Mage::getModel('bystritsky_action/action')->load($id));

        $this->loadLayout()->_setActiveMenu('bystritsky_action');
        $this->_addContent($this->getLayout()->createBlock('bystritsky_action/adminhtml_actions_edit'));
        $this->renderLayout();
    }

    public function saveAction()
    {
        if ($data = $this->getRequest()->getPost()) {
            try {
                $data = $this->_filterDateTime($data, ['create_datetime', 'start_datetime', 'end_datetime']);
                $model = Mage::getModel('bystritsky_action/action');
                $model->setData($data)->setId($this->getRequest()->getParam('id'));

                /*
                 if (!$model->getCreateDatetime()) {
                     $model->setCreateDatetime(now());
                 }
                */

                $model->save();


                Mage::getSingleton('adminhtml/session')->addSuccess($this->__('Action was saved successfully'));
                Mage::getSingleton('adminhtml/session')->setFormData(false);
                $this->_redirect('*/*/');
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                Mage::getSingleton('adminhtml/session')->setFormData($data);
                $this->_redirect('*/*/edit', [
                    'id' => $this->getRequest()->getParam('id')
                ]);
            }
            return;
        }
        Mage::getSingleton('adminhtml/session')->addError($this->__('Unable to find item to save'));
        $this->_redirect('*/*/');
    }

    public function deleteAction()
    {
        if ($id = $this->getRequest()->getParam('id')) {
            try {
                Mage::getModel('bystritsky_action/action')->setId($id)->delete();
                Mage::getSingleton('adminhtml/session')->addSuccess($this->__('Action was deleted successfully'));
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                $this->_redirect('*/*/edit', ['id' => $id]);
            }
        }
        $this->_redirect('*/*/');
    }

    public function massDeleteAction()
    {
        $actions = $this->getRequest()->getParam('actions', null);

        if (is_array($actions) && sizeof($actions) > 0) {
            try {
                foreach ($actions as $id) {
                    Mage::getModel('bystritsky_action/action')->setId($id)->delete();
                }
                $this->_getSession()->addSuccess($this->__('Total of %d actions have been deleted', sizeof($actions)));
            } catch (Exception $e) {
                $this->_getSession()->addError($e->getMessage());
            }
        } else {
            $this->_getSession()->addError($this->__('Please select news'));
        }
        $this->_redirect('*/*');
    }
}