<?php
Mage::helper('ayah')->includeAyah();

/**
 * Observe action methods for AYAH validation
 *
 * @author Christoph Frenes <christoph.frenes@aoemedia.de>
 */
class Aoe_Ayah_Model_Observer
{
    /**
     * validate AYAH results
     *
     * @param Varien_Event_Observer $event 
     */
    public function validateAyah(Varien_Event_Observer $observer)
    {
        if (Mage::helper('ayah')->isActive()) {
            $ayah = new AYAH(array(
                'publisher_key' => Mage::getStoreConfig('ayah/config/publickey'),
                'scoring_key'   => Mage::getStoreConfig('ayah/config/scorekey'),
                'debug_mode'    => Mage::getStoreConfigFlag('ayah/config/debug_mode')
            ));

            if (!$ayah->scoreResult()) {
                $session    = Mage::getSingleton('customer/session'); /* @var $session Mage_Customer_Model_Session */
                $controller = $observer->getControllerAction();
         
                $session->addError(Mage::helper('captcha')->__("We couldn't identify you as a human. Please prove your humanity."));
                $controller->setFlag('', Mage_Core_Controller_Varien_Action::FLAG_NO_DISPATCH, true);
                $session->setCustomerFormData($controller->getRequest()->getPost());
                $controller->getResponse()->setRedirect(Mage::getUrl('*/*/create'));
                
                return $this;
            }
        }
    }
}