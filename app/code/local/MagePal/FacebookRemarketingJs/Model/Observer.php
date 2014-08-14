<?php
/**
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Magento to newer
 * versions in the future. If you wish to customize Magento for your
 * needs please refer to http://www.magentocommerce.com for more information.
 *
 * @package     MagePal_FacebookRemarketingJs
 */


/**
 * FacebookRemarketingJs module observer
 */
class MagePal_FacebookRemarketingJs_Model_Observer
{

    /**
     * Add order information into GA block to render on checkout success pages
     *
     * @param Varien_Event_Observer $observer
     */
    public function setFacebookRemarketingJsOnOrderSuccessPageView(Varien_Event_Observer $observer)
    {
        $orderIds = $observer->getEvent()->getOrderIds();
        if (empty($orderIds) || !is_array($orderIds)) {
            return;
        }
        $block = Mage::app()->getFrontController()->getAction()->getLayout()->getBlock('facebook_remarketing_js');
        if ($block) {
            $block->setOrderIds($orderIds);
        }
    }

 
}
