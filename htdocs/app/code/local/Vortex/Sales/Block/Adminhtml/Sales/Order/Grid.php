<?php

/**
 * @author: Hieu Nguyen
 */
class Vortex_Sales_Block_Adminhtml_Sales_Order_Grid extends Mage_Adminhtml_Block_Sales_Order_Grid
{
    /**
     * @return $this
     */
    protected function _prepareColumns()
    {
        parent::_prepareColumns();

        $this->addColumn('billing_postcode', array(
            'header' => Mage::helper('sales')->__('Billing Postcode'),
            'index' => 'billing_postcode',
        ));

        $this->addColumn('method', array(
            'header' => Mage::helper('sales')->__('Payment Method'),
            'index' => 'method',
        ));

        return $this;

    }
}