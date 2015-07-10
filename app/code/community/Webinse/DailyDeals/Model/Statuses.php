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
 * Statuses model
 *
 * @category  Webinse
 * @package   Webinse_DailyDeals
 * @author    Webinse Team <info@webinse.com>
 * @copyright 2015 Webinse Ltd. (https://www.webinse.com)
 * @license   The Open Software License 3.0
 * @link      http://opensource.org/licenses/OSL-3.0
 */
class Webinse_DailyDeals_Model_Statuses extends Mage_Core_Model_Abstract
{
    protected function _construct()
    {
        $this->_init('dailydeals/statuses');
    }

    public function getOptionsStatusArray()
    {
        $statuses = array();
        $collection = Mage::getModel('dailydeals/statuses')->getCollection()->getData();
        foreach ($collection as $item) {
            $statuses[$item['code']] = $item['title'];
        }

        return $statuses;

    }

}