<?php

class Bystritsky_Action_Model_Action extends Mage_Core_Model_Abstract
{
    const AWAITED = 0;
    const ACTING = 1;
    const COMPLITED = 2;

    private $timeFields = ['create_datetime', 'start_datetime', 'end_datetime'];

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
    public function load($id, $field = null)
    {
        $resource = $this->_getResource();
        if (!$resource) {
            throw new UnexpectedValueException('Resource instance is not available');
        }

        parent::load($id, $field);

        foreach ($this->timeFields as $field) {
            if ($raw = $this->getData($field)) {
                $time = Mage::getModel('core/date')->timestamp(strtotime($raw));
                //$dateTime = Mage::helper('core')->formatDate($raw, true);
                $dateTime = date("Y-m-d H:i:s", $time);
                $this->setData($field, date($dateTime));
            }
        }

        return $this;
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

    public function save()
    {
        foreach ($this->timeFields as $field) {
            if ($raw = $this->getData($field)) {
                //$locale = Mage::app()->getLocale()->getLocaleCode();
                $time = Mage::getModel('core/date')->gmtTimestamp(strtotime($raw));
                //$dateTime = DateTime::createFromFormat($locale)
                $this->setData($field, $time);
            }
        }

        // cron job
        $currentDatetime = Mage::getModel('core/date')->gmtTimestamp();
        $startDatetime = $this->getStartDatetime();
        $endDatetime = $this->getEndDatetime();

        if ($startDatetime > $currentDatetime) {
            $this->setStatus(self::AWAITED);
        } elseif ($endDatetime && $currentDatetime > $endDatetime) {
            $this->setStatus(self::COMPLITED);
        } else {
            $this->setStatus(self::ACTING);
        }

        return parent::save();
    }

    public function updateStatus() {
        /**
         * @var $collection Bystritsky_Action_Model_Action[]
         */
        $collection = Mage::getModel('bystritsky_action/action')->getCollection()->load();
        foreach ($collection as $action) {
            $action->save();
        }
    }
}