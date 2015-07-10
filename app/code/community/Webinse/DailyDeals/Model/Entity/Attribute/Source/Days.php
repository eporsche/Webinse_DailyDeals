<?php

/**
 * Webinse_DailyDeals_Model_Entity_Attribute_Source_Days
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
 * Webinse_DailyDeals_Model_Entity_Attribute_Source_Days.
 *
 * .
 *
 * @category  Webinse
 * @package   Webinse_DailyDeals
 * @author    Webinse Team <info@webinse.com>
 * @copyright 2015 Webinse Ltd. (https://www.webinse.com)
 * @license   The Open Software License 3.0
 * @link      http://opensource.org/licenses/OSL-3.0
 */
class Webinse_DailyDeals_Model_Entity_Attribute_Source_Days extends Mage_Eav_Model_Entity_Attribute_Source_Abstract
{

    /**
     * Retrieve All options
     *
     * @return array
     */
    public function getAllOptions()
    {
        return array(
            array('value' => '0', 'label' => 'Sunday'),
            array('value' => '1', 'label' => 'Monday'),
            array('value' => '2', 'label' => 'Tuesday'),
            array('value' => '3', 'label' => 'Wednesday'),
            array('value' => '4', 'label' => 'Thursday'),
            array('value' => '5', 'label' => 'Friday'),
            array('value' => '6', 'label' => 'Saturday'),
        );
    }
}