<?php
/**
 * Description of Data
 *
 * @author Christoph Frenes <christoph.frenes@aoemedia.de>
 */
class Aoe_Ayah_Helper_Data extends Mage_Core_Helper_Abstract
{
    /**
     *
     * @return boolean 
     */
    public function isActive()
    {
        $publicKey = Mage::getStoreConfig('ayah/config/publickey');
        $scoreKey  = Mage::getStoreConfig('ayah/config/scorekey');
        $active    = Mage::getStoreConfigFlag('ayah/config/enable');
        
        if ($active && !empty($publicKey) && !empty($scoreKey)) {
            return true;
        }
        
        return false;
    }
    
    public function includeAyah()
    {
        if (!class_exists('ayah', false)) {
            require_once Mage::getBaseDir('lib') . DS . 'Ayah' . DS . 'ayah.php';
        }
    }
}