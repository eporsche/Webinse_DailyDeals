<?php
/**
 * Webinse_DailyDeals_Model_System_Config_Source_SaveInOptions
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
 * Webinse_DailyDeals_Model_System_Config_Source_SaveInOptions.
 * Model with options "You save in"
 *
 * @category  Webinse
 * @package   Webinse_DailyDeals
 * @author    Webinse Team <info@webinse.com>
 * @copyright 2015 Webinse Ltd. (https://www.webinse.com)
 * @license   The Open Software License 3.0
 * @link      http://opensource.org/licenses/OSL-3.0
 */
class Webinse_DailyDeals_Model_System_Config_Source_SaveInOptions
{
    /**
     * Options getter
     *
     * @return array
     */
    public function toOptionArray()
    {
        return array(
            array('value' => 'money', 'label' => Mage::helper('adminhtml')->__('Money')),
            array('value' => 'percentage', 'label' => Mage::helper('adminhtml')->__('Percent')),
        );
    }
}