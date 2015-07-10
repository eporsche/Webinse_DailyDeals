<?php

/**
 * Webinse_DailyDeals_Model_System_Config_Source_Enabling
 *
 * PHP Version 5.5.9
 *
 * @category  Webinse
 * @package   Webinse_DailyDeals
 * @author    Webinse Team <info@webinse.com>
 * @copyright 2015 Webinse Ltd. (https://www.webinse.com)
 * @license   The Open Software License 3.0
 * @link      http://opensource.org/licenses/OSL-3.0
 */

/**
 * Webinse_DailyDeals_Model_System_Config_Source_Enabling.
 * Model for enabling and disabling
 *
 * @category  Webinse
 * @package   Webinse_DailyDeals
 * @author    Webinse Team <info@webinse.com>
 * @copyright 2015 Webinse Ltd. (https://www.webinse.com)
 * @license   The Open Software License 3.0
 * @link      http://opensource.org/licenses/OSL-3.0
 */
class Webinse_DailyDeals_Model_System_Config_Source_Enabling
{

    /**
     * Options getter
     *
     * @return array
     */
    public function toOptionArray()
    {
        return array(
            array('value' => true, 'label' => Mage::helper('adminhtml')->__('Enabled')),
            array('value' => false, 'label' => Mage::helper('adminhtml')->__('Disabled')),
        );
    }

    /**
     * Get options in "key-value" format
     *
     * @return array
     */
    public function toArray()
    {
        return array(
            1 => Mage::helper('adminhtml')->__('Enabled'),
            0 => Mage::helper('adminhtml')->__('Disabled'),

        );
    }

}
