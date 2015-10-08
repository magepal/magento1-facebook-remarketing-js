<?php
/**
 * Facebook Page Block
 *
 * @package    MagePal_FacebookRemarketingJs
 * @author     R.S <rs@magepal.com>
 */


class MagePal_FacebookRemarketingJs_Block_Fb extends Mage_Core_Block_Template
{
    
    private $orderTotal = .01;
    private $orderCollection = NULL;
    
    
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
    protected function getConversionTrackingCode()
    {
        if(!$this->showFacebookConversionTracking()){
           return; 
        }
        
        $result = array();
        
        foreach ($this->getOrderCollection() as $order) {            
            $result[] = sprintf("window._fbq.push(['track', '%s', {'value':'%s','currency':'%s'}]);",
                $this->getConfigValue('conversion_account'),
                $order->getBaseGrandTotal(),
                $this->getCurrency()   
            );
        }
        
        return implode("\n", $result);
    }
    
    
    private function getOrderCollection(){
        $orderIds = $this->getOrderIds();
        
        if(!$this->orderCollection){
            $this->orderCollection = Mage::getResourceModel('sales/order_collection')
                                        ->addFieldToFilter('entity_id', array('in' => $orderIds));
        }
        
        return $this->orderCollection;
    }
    
    /**
     * Check if conversion tracking is enabled
     *
     * @return bool
     */
    public function showFacebookConversionTracking(){
        
        $orderIds = $this->getOrderIds();
        if (empty($orderIds) || !is_array($orderIds) || !Mage::helper('facebookremarketingjs')->isConversionAvailable()) {
            return false;
        }
        
        return true;
    }

    /**
     * Get system config from field name
     *
     * @return string
     */
    public function getConfigValue($field){
        return Mage::getStoreConfig("facebookremarketingjs/marketing/$field");
    }
    
    /**
     * Get currency string
     *
     * @return string
     */
    public function getCurrency(){
        return $this->getConfigValue('currency') ? $this->getConfigValue('currency') : 'USD';
    }
    
    /**
     * Get Facebook Id from config
     *
     * @return string
     */
    public function getRemarketingAccountId(){
        if(!Mage::helper('facebookremarketingjs')->isRemarketingAvailable()){
           return false; 
        }
        
        return Mage::getStoreConfig(MagePal_FacebookRemarketingJs_Helper_Data::XML_PATH_REMARKETING_ACCOUNT);
    }
    
    /**
     * Get order total
     *
     * @return float
     */
    public function getOrderTotal(){
        if($this->showFacebookConversionTracking()){
            foreach ($this->getOrderCollection() as $order) {
                $this->orderTotal += $order->getBaseGrandTotal();
            }
        }
        
        return Mage::getModel('directory/currency')->format(
                    $this->orderTotal, 
                    array('display'=>Zend_Currency::NO_SYMBOL), 
                    false
                );
    }
}
