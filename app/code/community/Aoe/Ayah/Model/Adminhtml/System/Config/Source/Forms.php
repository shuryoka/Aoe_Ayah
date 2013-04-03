<?php
/**
 * Description of Forms
 *
 * @author chris
 */
class Aoe_Ayah_Model_Adminhtml_System_Config_Source_Forms
{
    /**
     * Options getter
     *
     * @return array
     */
    public function toOptionArray()
    {
        $ayahHelper = Mage::helper('ayah'); /* @var $ayahHelper Aoe_Ayah_Helper_Data */
        
        return array(
            array(
                'value' => 'account_create',
                'label' => $ayahHelper->__('Registration')
            ),
            array(
                'value' => 'account_login',
                'label' => $ayahHelper->__('Login')
            ),
            array(
                'value' => 'forgot_password',
                'label' => $ayahHelper->__('Forgot password')
            ),
            array(
                'value' => 'checkout_customer',
                'label' => $ayahHelper->__('Checkout (Customer)')
            ),
            array(
                'value' => 'checkout_guest',
                'label' => $ayahHelper->__('Checkout (Guest)')
            )
        );
    }
}