<?php

class Bystritsky_Action_Helper_Data extends Mage_Core_Helper_Abstract
{
    public function getImagePath()
    {
        return Mage::getBaseDir('media') . DS . 'bystritsky_action';
    }

    public function generateImageFilename($filename)
    {
        if (!file_exists($this->getImagePath() . DS . $filename)) {
            return $filename;
        }
        $n = 0;
        $ext = pathinfo($filename, PATHINFO_EXTENSION);
        $file = basename($filename, "." . $ext);
        do {
            $n++;
            $new_filename = "{$file}_{$n}.{$ext}";
        } while (file_exists($this->getImagePath() . DS . $new_filename));
        return $new_filename;

    }

    public function getImageUrl($filename)
    {
        $base = Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_MEDIA) . 'bystritsky_action/';
        if ($filename) {
            return $base . $filename;
        } else {
            return null;
        }
    }

    public function getFilename($url)
    {
        return array_reverse(explode('/', $url))[0];
    }

    public function toLocalTime($dateTime)
    {

    }
}