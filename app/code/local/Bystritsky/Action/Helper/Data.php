<?php

class Bystritsky_Action_Helper_Data extends Mage_Core_Helper_Abstract
{
    public function getImagesPath()
    {
        return Mage::getBaseDir('media') . DS . 'bystritsky_action';
    }
    public function getImagePath($filename)
    {
        return $this->getImagesPath() . DS . $filename;
    }

    public function generateImageFilename($filename)
    {
        if (!file_exists($this->getImagePath($filename))) {
            return $filename;
        }
        $n = 0;
        $ext = pathinfo($filename, PATHINFO_EXTENSION);
        $file = basename($filename, "." . $ext);
        do {
            $n++;
            $new_filename = "{$file}_{$n}.{$ext}";
        } while (file_exists($this->getImagePath($new_filename)));
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

    public function getResizedImageUrl($image, $nWidth, $nHeight)
    {
        $path = Mage::getBaseDir('media')
            . DS . 'bystritsky_action'
            . DS . $nWidth
            . DS . $nHeight;
        $file = $path . DS . $image;
        if (!file_exists($file)) {
            if (!is_dir($path)) {
                mkdir($path, 0777, true);
            }
            $original = $this->getImagePath($image);
            list($oWidth, $oHeight) = getimagesize($original);
            $original = imagecreatefromjpeg($original);
            $resized = imagecreatetruecolor($nWidth, $nHeight);

            imagecopyresampled($resized, $original, 0, 0, 0, 0, $nWidth, $nHeight, $oWidth, $oHeight);
            imagejpeg($resized, $file);
        }
        return $this->getImageUrl("$nWidth/$nHeight/$image");
    }

    public function removeImage($fileName, $path = null) {
        if(!$fileName) {
            return;
        }
        if (!$path) {
            $path = $this->getImagesPath();
        }
        $fullFileName = $path . DS . $fileName;
        if (file_exists($fullFileName) && is_file($fullFileName)) {
            unlink($fullFileName);
        }
        foreach (scandir($path) as $dirElementName) {
            $dirElementFullName = $path . DS . $dirElementName;
            if ($dirElementName != '.' && $dirElementName != '..' && is_dir($dirElementFullName)) {
                $this->removeImage($fileName, $dirElementFullName);
            }
        }

    }
}