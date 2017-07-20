<?php

/**
 * @author: Hieu Nguyen
 */
class Vortex_Sales_Helper_Data extends Mage_Core_Helper_Abstract
{
    const COLUMN_BILLING_POSTCODE = 'billing_postcode';
    const COLUMN_PAYMENT_METHOD = 'method';

    /**
     * update sale grid table
     */
    public function updateOrderGridData($orderId = null)
    {
        $orders = $this->_getOrdersData($orderId);

        foreach ($orders as $order) {
            $billingPostcode = $this->_getColumnValue($order['entity_id'], 'sales_flat_order_address', 'postcode', 'address_type = \'billing\'');
            $paymentMethod = $this->_getColumnValue($order['entity_id'], 'sales_flat_order_payment', 'method');

            if ($billingPostcode && empty($order[self::COLUMN_BILLING_POSTCODE])) {
                $this->_updateOrderGridField($order['entity_id'], self::COLUMN_BILLING_POSTCODE, $billingPostcode);
            }

            if ($paymentMethod && empty($order[self::COLUMN_PAYMENT_METHOD])) {
                $methodLabel = Mage::getStoreConfig('payment/' . $paymentMethod . '/title');
                $this->_updateOrderGridField($order['entity_id'], self::COLUMN_PAYMENT_METHOD, $methodLabel);
            }
        }
    }

    /**
     * @param $id
     * @param $field
     * @param $value
     */
    protected function _updateOrderGridField($id, $field, $value)
    {
        $resource = Mage::getSingleton('core/resource');
        $writeAdapter = $this->_getWriteAdapter();
        $data = array(
            $field => $value
        );
        $writeAdapter->update($resource->getTableName('sales_flat_order_grid'), $data);
    }

    /**
     * @param $id
     * @param $table
     * @param $field
     * @param $where
     * @return string
     */
    protected function _getColumnValue($id, $table, $field, $where = null)
    {
        $resource = Mage::getSingleton('core/resource');
        $writeAdapter = $this->_getWriteAdapter();
        $select = $writeAdapter->select()
            ->from($resource->getTableName($table), array($field))->where('parent_id = ?', $id);

        if ($where) {
            $select->where($where);
        }
        return $writeAdapter->fetchOne($select);
    }

    /**
     * get order grid records which need update
     *
     * @param $orderId
     * @return array
     */
    protected function _getOrdersData($orderId)
    {
        $resource = Mage::getSingleton('core/resource');
        $writeAdapter = $this->_getWriteAdapter();

        $select = $writeAdapter->select()
            ->from($resource->getTableName('sales_flat_order_grid'));
        if ($orderId) {
            $select->where('entity_id = ?', $orderId);
        }
        $select->where(self::COLUMN_BILLING_POSTCODE . ' is NULL')
            ->orWhere(self::COLUMN_PAYMENT_METHOD . ' is NULL');

        $result = $writeAdapter->fetchAll($select);

        return $result;
    }

    /**
     * @return Magento_Db_Adapter_Pdo_Mysql
     */
    protected function _getWriteAdapter()
    {
        $resource = Mage::getSingleton('core/resource');
        /**
         * @var $writeAdapter Magento_Db_Adapter_Pdo_Mysql
         */
        $writeAdapter = $resource->getConnection('core_write');

        return $writeAdapter;
    }
}