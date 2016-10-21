<?php

class Bystritsky_Action_Model_Dependency extends Mage_Core_Model_Abstract
{
    protected function _construct()
    {
        $this->_init('bystritsky_action/dependency');
    }

    /**
     * Load object data
     *
     * @param   integer $id
     * @return  Mage_Core_Model_Abstract
     */
    public function load($id, $field = null)
    {
        $resource = $this->_getResource();
        if (!$resource) {
            throw new UnexpectedValueException('Resource instance is not available');
        }

        return parent::load($id, $field);

    }

}