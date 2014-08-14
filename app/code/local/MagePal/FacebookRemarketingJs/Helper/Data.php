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
    const XML_PATH_ACCOUNT = 'facebookremarketingjs/marketing/account';

    /**
     * Whether GA is ready to use
     *
     * @param mixed $store
     * @return bool
     */
    public function isFacebookRemarketingJsAvailable($store = null)
    {
        $accountId = Mage::getStoreConfig(self::XML_PATH_ACCOUNT, $store);
        return $accountId && Mage::getStoreConfigFlag(self::XML_PATH_ACTIVE, $store);
    }
}
