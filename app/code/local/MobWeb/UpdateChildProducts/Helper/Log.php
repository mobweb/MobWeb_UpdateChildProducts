<?php

class MobWeb_UpdateChildProducts_Helper_Log extends Mage_Core_Helper_Abstract
{
    public function log($msg, $level = NULL)
    {
        Mage::log($msg, $level, $this->_getModuleName() . '.log');
    }
}
