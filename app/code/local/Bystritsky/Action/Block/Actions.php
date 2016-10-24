<?php

class Bystritsky_Action_Block_Actions extends Mage_Core_Block_Template
{
    public function __construct()
    {
        parent::__construct();
        $collection = Mage::getModel('bystritsky_action/action')
            ->getCollection()->addFieldToFilter('is_active', '1')
            ->addFieldToFilter('status',  Bystritsky_Action_Model_Action::ACTING)
            ->setOrder('start_datetime', 'DESC');
        $this->setCollection($collection);
    }

    /*
        public function getActionsCollection()
        {
            /** @var Bystritsky_Action_Model_Resource_Action_Collection $actions *\/

            $page = $this->getRequest()->getParam('p', 1);
            $limit = $this->getRequest()->getParam('limit', 10);
            $actions = Mage::getModel('bystritsky_action/action')->getCollection();
            $actions
                ->addFieldToFilter('is_active', '1')
                ->addFieldToFilter('start_datetime', ['lt' => Mage::getModel('core/date')->gmtDate()])
                ->addFieldToFilter('end_datetime', [['gt' => Mage::getModel('core/date')->gmtDate()], ['null' => 'true']])
                ->setPageSize($limit)
                ->setCurPage($page)
                ->setOrder('start_datetime', 'DESC');
            //Mage::log((string) $actions->getSelect());
            return $this->dirtyHack($actions);
        }
    */
    protected function _prepareLayout()
    {
        parent::_prepareLayout();
        $pager = $this->getLayout()->createBlock('page/html_pager', 'custom.pager');
        $pager->setAvailableLimit([10 => 10, 20 => 20, 'all' => 'all']);
        $pager->setCollection($this->getCollection());
        $this->setChild('pager', $pager);
        $this->getCollection();
        return $this;
    }


    public function getPagerHtml()
    {
        return $this->getChildHtml('pager');
    }
    /*
        private function dirtyHack($collection)
        {
            $timeFields = ['create_datetime', 'start_datetime', 'end_datetime'];
            foreach ($collection as $element) {
                foreach ($timeFields as $field) {
                    if ($raw = $element->getData($field)) {
                        $time = Mage::getModel('core/date')->timestamp(strtotime($raw));
                        //$dateTime = Mage::helper('core')->formatDate($raw, true);
                        $dateTime = date("Y-m-d H:i:s", $time);
                        $element->setData($field, date($dateTime));
                    }
                }

            }
            return $collection;
        }
    */
}
