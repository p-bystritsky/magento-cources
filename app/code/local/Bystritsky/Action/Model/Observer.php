<?php

class Bystritsky_Action_Model_Observer
{
    public function topmenuGethtmlBefore(Varien_Event_Observer $observer)
    {
        $menu = $observer->getMenu();
        $tree = $menu->getTree();

        $node = new Varien_Data_Tree_Node([
            'name'   => 'Actions',
            'id'     => 'actions',
            'url'    => Mage::getUrl('action'),
        ], 'id', $tree, $menu);
        $menu->addChild($node);
    }
}