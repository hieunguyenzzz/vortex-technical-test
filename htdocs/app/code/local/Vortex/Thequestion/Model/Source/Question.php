<?php

/**
 * @author: Hieu Nguyen
 */
class Vortex_Thequestion_Model_Source_Question extends Mage_Eav_Model_Entity_Attribute_Source_Abstract
{
    const CONFIG_WHERE_DID_YOU_HEAR_US = 'customer/create_account/where_did_you_hear_us';

    /**
     * Get all options
     *
     * @return array
     */
    public function getAllOptions()
    {
        $options = Mage::getStoreConfig(self::CONFIG_WHERE_DID_YOU_HEAR_US);
        $options = explode(',', $options);
        $result = array(
            array(
                'value' => '',
                'label' => ''
            )
        );

        foreach ($options as $option) {
            $result[] = array(
                'value' => $option,
                'label' => $option
            );
        }

        return $result;
    }
}