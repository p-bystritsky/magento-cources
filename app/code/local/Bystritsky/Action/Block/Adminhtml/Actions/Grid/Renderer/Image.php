<?php
class Bystritsky_Action_Block_Adminhtml_Actions_Grid_Renderer_Image extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract
{
    public function render(Varien_Object $row)
    {
        return $this->_getValue($row);
    }
    protected function _getValue(Varien_Object $row)
    {
        $val = $row->getData($this->getColumn()->getIndex());
        if ($val) {
            $val = str_replace("no_selection", "", $val);
            $helper = Mage::helper('bystritsky_action');
            $url = $helper->getImageUrl($val);
            $out = "<img src=". $url ." width='60px'/>";
            return $out;
        } else {
            return null;
        }
    }
}