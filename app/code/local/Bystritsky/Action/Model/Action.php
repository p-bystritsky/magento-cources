<?php

class Bystritsky_Action_Model_Action extends Mage_Core_Model_Abstract
{
    protected function _construct()
    {
        $this->_init('bystritsky_action/action');
    }
    /**
     * Load object data
     *
     * @param   integer $id
     * @return  Mage_Core_Model_Abstract
     */
    public function load($id, $field=null)
    {
        $resource =  $this->_getResource();
        if (!$resource) {
            throw new UnexpectedValueException('Resource instance is not available');
        }

        return parent::load($id, $field);
    }


    protected function _afterDelete()
    {
        $helper = Mage::helper('bystritsky_action');
        @unlink($helper->getImagePath($this->getId()));
        return parent::_afterDelete();
    }

    public function getImageUrl()
    {
        $helper = Mage::helper('bystritsky_action');
        if ($filename = $this->getImage()) {
            return $helper->getImageUrl($filename);
        }
        return null;
    }

}