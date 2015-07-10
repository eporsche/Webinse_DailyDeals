<?php

/**
 * Webinse_DailyDeals_Block_Adminhtml_Widget_Grid_Column_Renderer_Days
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
 * Webinse_DailyDeals_Block_Adminhtml_Widget_Grid_Column_Renderer_Days.
 * .
 *
 * @category  Webinse
 * @package   Webinse_DailyDeals
 * @author    Webinse Team <info@webinse.com>
 * @copyright 2015 Webinse Ltd. (https://www.webinse.com)
 * @license   The Open Software License 3.0
 * @link      http://opensource.org/licenses/OSL-3.0
 */
class Webinse_DailyDeals_Block_Adminhtml_Widget_Grid_Column_Renderer_Days
    extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract
{
    /**
     * Render days of week
     *
     * @param Varien_Object $row row
     *
     * @return string
     */
    public function render(Varien_Object $row)
    {
        if ($row->getDealUpdateDays()) {
            $days = array(1 => 'Monday', 2 => 'Tuesday', 3 => 'Wednesday', 4 => 'Thursday',
                5 => 'Friday', 6 => 'Saturday', 7 => 'Sunday');
            $daysString = $row->getDealUpdateDays();
            $daysArray = explode(',', $daysString);
            $result = array();
            foreach ($daysArray as $dayNumber) {
                $result[] = $days[$dayNumber];
            }
            return implode(',', $result);
        }
    }
}