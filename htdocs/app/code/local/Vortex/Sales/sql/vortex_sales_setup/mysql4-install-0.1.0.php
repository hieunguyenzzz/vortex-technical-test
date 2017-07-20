<?php
/**
 * @author: Hieu Nguyen
 */
/* @var $installer Mage_Core_Model_Resource_Setup */
$installer = $this;

$installer->startSetup();

$tableName = Mage::getSingleton('core/resource')->getTableName('sales_flat_order_grid');
$installer->getConnection()->addColumn($tableName, 'billing_postcode', 'varchar(99) DEFAULT NULL');
$installer->getConnection()->addColumn($tableName, 'method', 'varchar(99) DEFAULT NULL');


$installer->endSetup();