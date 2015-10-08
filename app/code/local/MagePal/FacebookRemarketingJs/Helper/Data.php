<?php
/**
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Magento to newer
 * versions in the future. If you wish to customize Magento for your
 * needs please refer to http://www.magentocommerce.com for more information.
 *
 */

/**
 * FacebookRemarketingJs data helper
 *
 * @package    MagePal_FacebookRemarketingJs
 */
class MagePal_FacebookRemarketingJs_Helper_Data extends Mage_Core_Helper_Abstract
{

    /**
     * Config paths for using throughout the code
     */
    const XML_PATH_ACTIVE  = 'facebookremarketingjs/marketing/active';
    
    const XML_PATH_REMARKETING_AVAILABLE = 'facebookremarketingjs/marketing/remarketing_active';
    const XML_PATH_REMARKETING_ACCOUNT = 'facebookremarketingjs/marketing/remarketing_account';
    
    const XML_PATH_CONVERSION_AVAILABLE = 'facebookremarketingjs/marketing/conversion_active';
    const XML_PATH_CONVERSION_ACCOUNT = 'facebookremarketingjs/marketing/conversion_account';

    /**
     * Whether GA is ready to use
     *
     * @param mixed $store
     * @return bool
     */
    public function isFacebookRemarketingJsAvailable($store = null)
    {
        
        return ($this->isRemarketingAvailable($store) || $this->isConversionAvailable($store)) 
                    && Mage::getStoreConfigFlag(self::XML_PATH_ACTIVE, $store);
    }
    
    /**
     * Whether Facebook Remarketing JS is ready to use
     *
     * @param mixed $store
     * @return bool
     */
    public function isRemarketingAvailable($store = null){
        return (Mage::getStoreConfig(self::XML_PATH_REMARKETING_AVAILABLE, $store) 
                    && Mage::getStoreConfig(self::XML_PATH_REMARKETING_ACCOUNT, $store));
    }
    
    /**
     * Whether Facebook Conversion is Enable
     *
     * @param mixed $store
     * @return bool
     */
    public function isConversionAvailable($store = null){
        return (Mage::getStoreConfig(self::XML_PATH_CONVERSION_AVAILABLE, $store) 
                    && Mage::getStoreConfig(self::XML_PATH_CONVERSION_ACCOUNT, $store));
    }
}
