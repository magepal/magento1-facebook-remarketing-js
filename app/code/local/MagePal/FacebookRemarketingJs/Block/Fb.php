<?php
/**
 * Facebook Page Block
 *
 * @package    MagePal_FacebookRemarketingJs
 * @author     R.S <rs@magepal.com>
 */


class MagePal_FacebookRemarketingJs_Block_Fb extends Mage_Core_Block_Template
{
    
    private $remId = NULL;
    private $conversionId = NULL;
    private $conversionLabel = NULL;
    
    
    /**
     * Render FacebookRemarketingJs tracking scripts
     *
     * @return string
     */
    protected function _toHtml()
    {
        if (!Mage::helper('facebookremarketingjs')->isFacebookRemarketingJsAvailable()) {
            return '';
        }

        return parent::_toHtml();
    }
    

    /**
     * Render information about specified orders and their items
     *
     * @return string
     */
    protected function _getOrdersTrackingCode()
    {
        if(!$this->showFbOrderTracking()){
           return; 
        }
        
        $orderIds = $this->getOrderIds();
        if (empty($orderIds) || !is_array($orderIds)) {
            return;
        }
        $collection = Mage::getResourceModel('sales/order_collection')
            ->addFieldToFilter('entity_id', array('in' => $orderIds));
        $result = array();
        
        
        foreach ($collection as $order) {
            
            $result[] = sprintf("window._fbq.push(['track', '%s', {'value':'%s','currency':'USD'}]);",
                $this->getConfigValue('pixel_category_checkouts_value'),
                $order->getBaseGrandTotal()
            );
    
            
        }
        return implode("\n", $result);
    }
    
    public function showFbOrderTracking(){
        if($this->getConfigValue('pixel_category_checkouts') == 0 || !$this->getConfigValue('pixel_category_checkouts_value')){
           return false; 
        }
        
        $orderIds = $this->getOrderIds();
        if (empty($orderIds) || !is_array($orderIds)) {
            return false;
        }
        
        return true;
    }


    public function getConfigValue($field){
        return Mage::getStoreConfig("facebookremarketingjs/marketing/$field");
    }
    
    


}
