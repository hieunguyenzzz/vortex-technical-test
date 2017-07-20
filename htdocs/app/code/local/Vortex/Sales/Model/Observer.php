<?php

/**
 * @author: Hieu Nguyen
 */
class Vortex_Sales_Model_Observer
{
    public function salesModelServiceQuoteSubmitSuccess($observer)
    {
        $order = $observer->getOrder();
        if ($order->getId()) {
            Mage::helper('vortex_sales')->updateOrderGridData($order->getId());
        }
    }
}