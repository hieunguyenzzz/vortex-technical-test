<?php

/**
 * @author: Hieu Nguyen
 */
class Vortex_Thequestion_Model_Observer
{
    /**
     * @param $observer
     * @return $this
     */
    public function customerSaveBefore($observer)
    {
        $whereDidYouHearAboutUs = Mage::app()->getRequest()->getParam('where_did_you_hear_us');
        if (Mage::app()->getRequest()->getRouteName() == 'checkout') {
            $whereDidYouHearAboutUs = Mage::getSingleton('checkout/session')->getData('where_did_you_hear_us');
        }
        $customer = $observer->getCustomer();
        if ($whereDidYouHearAboutUs) {
            $customer->setData('where_did_you_hear_us', $whereDidYouHearAboutUs);
        }

        return $this;
    }

    /**
     * @return $this
     */
    public function salesQuoteCollectTotalsBefore()
    {
        $whereDidYouHearAboutUs = Mage::app()->getRequest()->getParam('where_did_you_hear_us');
        if (!empty($whereDidYouHearAboutUs)) {
            Mage::getSingleton('checkout/session')->setData('where_did_you_hear_us', $whereDidYouHearAboutUs);
        }

        return $this;
    }
}