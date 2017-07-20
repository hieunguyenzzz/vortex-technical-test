<?php
/**
 * @author: Hieu Nguyen
 */

require_once 'abstract.php';

class Update_Table_Sales_Grid extends Mage_Shell_Abstract
{
    public function run()
    {
        Mage::helper('vortex_sales')->updateOrderGridData();
    }
}

$shell = new Update_Table_Sales_Grid();
$shell->run();