<?php
/**
 * Provide methods for easy AYAH use
 *
 * @author Christoph Frenes <christoph.frenes@aoemedia.de>
 */
class Aoe_Ayah_Helper_Data extends Mage_Core_Helper_Abstract
{
    /**
     * check if AYAH is enabled
     *
     * @return boolean 
     */
    public function getIsActive()
    {
        $publicKey = Mage::getStoreConfig('ayah/config/publickey');
        $scoreKey  = Mage::getStoreConfig('ayah/config/scorekey');
        $active    = Mage::getStoreConfigFlag('ayah/config/enable');
        
        if ($active && !empty($publicKey) && !empty($scoreKey)) {
            return true;
        }
        
        return false;
    }
    
    /**
     * check if current page/form is AYAH protected
     * 
     * @param string form identifier
     * @return boolean 
     */
    public function getIsFormProtected($formId)
    {
        $protectedForms = explode(',', Mage::getStoreConfig('ayah/config/forms'));
        
        if (in_array($formId, $protectedForms)) {
            return true;
        }
        
        return false;
    }
    
    /**
     * initiate AYAH object with dynamic data from magento backend
     *
     * @return Ayah_Ayah 
     */
    protected function _setAyah()
    {
        $ayah = new Ayah_Ayah(array(
            'publisher_key' => Mage::getStoreConfig('ayah/config/publickey'),
            'scoring_key'   => Mage::getStoreConfig('ayah/config/scorekey'),
            'debug_mode'    => Mage::getStoreConfigFlag('ayah/config/debug_mode')
        ));
        
        return $ayah;
    }
    
    /**
     * get AYAH HTML
     *
     * @return string AYAH HTML box 
     */
    public function getHtml()
    {
        $ayah = $this->_setAyah();
        return $ayah->getPublisherHTML();
    }
    
    /**
     * check if submitted AYAH game is valid
     *
     * @return boolean  
     */
    public function getIsValid()
    {
        $formId = Mage::app()->getRequest()->getPost('ayahFormId');
        
        if (!$this->getIsFormProtected($formId)) {
            return true;
        }
        
        $ayah = $this->_setAyah();
        return $ayah->scoreResult();
    }
}