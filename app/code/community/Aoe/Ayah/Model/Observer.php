<?php
/**
 * Observe action methods for AYAH validation
 *
 * @author Christoph Frenes <christoph.frenes@aoemedia.de>
 */
class Aoe_Ayah_Model_Observer
{
    /**
     * @var Varien_Event_Observer 
     */
    protected $_observer;
    
    protected $_controller;
    
    /**
     * @var Mage_Customer_Model_Session
     */
    protected $_session;
    
    protected function _validateAyah()
    {
        $ayahHelper = Mage::helper('ayah'); /* @var $ayahHelper Aoe_Ayah_Helper_Data */
        
        if (!$ayahHelper->getIsActive() || $ayahHelper->getIsValid()) {
            return true;
        }
        
        $this->_session    = Mage::getSingleton('customer/session');
        $this->_controller = $this->_observer->getControllerAction();

        $this->_session->addError($ayahHelper->__("We couldn't identify you as a human. Please prove your humanity."));
        $this->_controller->setFlag('', Mage_Core_Controller_Varien_Action::FLAG_NO_DISPATCH, true);
        $this->_session->setCustomerFormData($this->_controller->getRequest()->getPost());

        return false;
    }
    
    /**
     * redirect to correct place if validation fails
     *
     * @param Varien_Event_Observer $observer
     * @param string $action 
     */
    protected function _setRedirectIfNeeded(Varien_Event_Observer $observer, $path = 'customer/account/index')
    {
        $this->_observer = $observer;
        
        if (!$this->_validateAyah()) {
            $this->_controller->getResponse()->setRedirect(Mage::getUrl($path));
        }
    }
    
    /**
     * validate registration
     *
     * @param Varien_Event_Observer $event 
     */
    public function validateAyahRegistration(Varien_Event_Observer $observer)
    {
        $this->_setRedirectIfNeeded($observer, 'customer/account/create');
        
        return $this;
    }
    
    /**
     * validate login
     *
     * @param Varien_Event_Observer $event 
     */
    public function validateAyahLogin(Varien_Event_Observer $observer)
    {
        $path = null;
        
        if (Mage::app()->getRequest()->getPost('ayahFormId') == 'checkout_customer') {
            $path = 'checkout/onepage/index';
        }
        
        $this->_setRedirectIfNeeded($observer, $path);
        
        return $this;
    }
    
    /**
     * validate forgot password
     *
     * @param Varien_Event_Observer $event 
     */
    public function validateAyahForgotPassword(Varien_Event_Observer $observer)
    {
        $this->_setRedirectIfNeeded($observer, 'customer/account/forgotpassword');
        
        return $this;
    }
}