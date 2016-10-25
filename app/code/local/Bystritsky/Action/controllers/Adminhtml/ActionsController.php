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

        $model = Mage::getModel('bystritsky_action/action');

        if ($data = Mage::getSingleton('adminhtml/session')->getFormData()) {
            $model->setData($data)->setId($id);
        } else {
            $model->load($id);
        }

        Mage::register('current_action', $model);

        $this->loadLayout()->_setActiveMenu('bystritsky_action');
        $this->_addLeft($this->getLayout()->createBlock('bystritsky_action/adminhtml_actions_edit_tabs'));
        $this->_addContent($this->getLayout()->createBlock('bystritsky_action/adminhtml_actions_edit'));
        $this->renderLayout();
    }

    public function saveAction()
    {
        $id = $this->getRequest()->getParam('id');
        if ($data = $this->getRequest()->getPost()) {
            $helper = Mage::helper('bystritsky_action');
            $model = Mage::getModel('bystritsky_action/action');
            $model->load($id);
            $model->addData($data)->setId($id);
            if ($selectedProducts = $this->getRequest()->getParam('selected_products', null)) {
                $selectedProducts = Mage::helper('adminhtml/js')->decodeGridSerializedInput($selectedProducts);
            } else {
                $selectedProducts = array();
            }
            $this->updateDependencies($id, $selectedProducts);
        }
        try {
            if (isset($_FILES['image']['name']) && $_FILES['image']['name'] != '') {
                $uploader = new Varien_File_Uploader('image');
                $uploader->setAllowedExtensions(['jpg', 'jpeg']); //, 'png', 'bmp', 'gif']);
                $uploader->setAllowRenameFiles(true);
                $uploader->setFilesDispersion(false);
                $uploader->save($helper->getImagesPath(), $_FILES['image']['name']); // Upload the image

                $model->addData(['image' => $uploader->getUploadedFileName()]);


            } elseif (isset($data['image']['delete']) && $data['image']['delete'] == 1) {
                $data['image'] = null;
                $model->addData(['image' => null]);
            } elseif (isset($data['image']['value'])) {
                $model->addData(['image' => $helper->getFileName($data['image']['value'])]);
            }
            $model->save();

            Mage::getSingleton('adminhtml/session')->addSuccess($this->__('Action was saved successfully'));
            Mage::getSingleton('adminhtml/session')->setFormData(false);
            $this->_redirect('*/*/');
            return;
        } catch (Exception $e) {
            if (isset($data['image']['value'])) {
                //$model->addData(['image' => $helper->getFileName($data['image']['value'])]);
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                Mage::getSingleton('adminhtml/session')->setFormData($data);
                $this->_redirect('*/*/edit', [
                    'id' => $id
                ]);
                return;
            }
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
            $this->_getSession()->addError($this->__('Please select actions'));
        }
        $this->_redirect('*/*');
    }

    public function productsAction()
    {
        $id = (int)$this->getRequest()->getParam('id');
        $model = Mage::getModel('bystritsky_action/action')->load($id);
        Mage::register('current_action', $model);
        $request = Mage::app()->getRequest();
        /*
        if (Mage::app()->getRequest()->isAjax()) {
            $this->loadLayout();
            echo $this->getLayout()->createBlock('bystritsky_action/adminhtml_actions_edit_tabs_products')->toHtml();
        }
*/
        if ($request->isAjax()) {

            $this->loadLayout();
            $layout = $this->getLayout();

            $root = $layout->createBlock('core/text_list', 'root', ['output' => 'toHtml']);

            $grid = $layout->createBlock('bystritsky_action/adminhtml_actions_edit_tabs_products');
            $root->append($grid);

            if (!$request->getParam('grid_only')) {
                $serializer = $layout->createBlock('adminhtml/widget_grid_serializer');
                /*
                 * При вызове функции initSerializerBlock блока сериализации, происходит привязка блока к гриду.
                 * Данная функция принимает 4 параметра: блок или имя грида в шаблоне, имя метода блока для получения
                 * выделенных элементов, имя скрытого инпута (это имя используется в контроллере при сохранении),
                 * и последним параметром идём название поля, которое используется в методе getSelectedNews в блоке грида
                 * для получения изменений выделения новостей.
                 */
                $serializer->initSerializerBlock($grid, 'getSelectedProducts', 'selected_products', 'selected_products');
                $root->append($serializer);
            }

            $this->renderLayout();
        }
    }

    /**
     * @param int $actionId
     * @param int[] $newProducts
     */
    public function updateDependencies($actionId, $newProducts)
    {
        $model = Mage::getModel('bystritsky_action/dependency');

        $actualProducts = $model
            ->getCollection()
            ->addFieldToFilter('action_id', $actionId)
            ->getColumnValues('product_id');

        $insert = array_diff($newProducts, $actualProducts);
        $delete = array_diff($actualProducts, $newProducts);

        if (!empty($insert)) {
            foreach ($insert as $productId) {
                $model->setActionId($actionId);
                $model->setProductId($productId);
                $model->save();
                $model->unsetData();
            }
        }

        if (!empty($delete)) {
            foreach ($delete as $productId) {
                $model->getCollection()
                    ->addFieldToFilter('action_id', $actionId)
                    ->addFieldToFilter('product_id', $productId)
                    ->getFirstItem()
                    ->delete();
                $model->unsetData();
            }
        }

        return $this;
    }

}