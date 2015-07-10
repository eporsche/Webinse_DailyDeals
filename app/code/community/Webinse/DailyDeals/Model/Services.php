<?php

/**
 * Webinse_DailyDeals_Model_Services
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
 * Webinse_DailyDeals_Model_Services.
 * Services
 *
 * @category  Webinse
 * @package   Webinse_DailyDeals
 * @author    Webinse Team <info@webinse.com>
 * @copyright 2015 Webinse Ltd. (https://www.webinse.com)
 * @license   The Open Software License 3.0
 * @link      http://opensource.org/licenses/OSL-3.0
 */
class Webinse_DailyDeals_Model_Services
{
    /**
     * Array for widget options
     *
     * @return array
     */
    public function toOptionArray()
    {
        return array(
            array('value' => 'dotted', 'label' => 'dotted'),
            array('value' => 'dashed', 'label' => 'dashed'),
            array('value' => 'solid', 'label' => 'solid'),
            array('value' => 'double', 'label' => 'double'),
            array('value' => 'groove', 'label' => 'groove'),
            array('value' => 'ridge', 'label' => 'ridge'),
            array('value' => 'inset', 'label' => 'inset'),
            array('value' => 'outset', 'label' => 'outset'),
        );
    }
}