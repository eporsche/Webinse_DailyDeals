<?php

/**
 * Webinse_DailyDeals_Model_DealProduct
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
 * Webinse_DailyDeals_Model_DealProduct.
 * .
 *
 * @category  Webinse
 * @package   Webinse_DailyDeals
 * @author    Webinse Team <info@webinse.com>
 * @copyright 2015 Webinse Ltd. (https://www.webinse.com)
 * @license   The Open Software License 3.0
 * @link      http://opensource.org/licenses/OSL-3.0
 */
class Webinse_DailyDeals_Model_DealProduct
{
    /**
     * Generation array with product to update today
     *
     * @param mixed $multiSelectStr multi select string
     *
     * @return array key = product id : value = deal_product_qty
     */
    public function getUpdateProduct($multiSelectStr)
    {
        $currentDay = Mage::getModel('core/date')->date('N');

        $startNumber = null;
        $endNumber = null;

        foreach ($multiSelectStr as $number) {
            if ($currentDay == $number) {
                $startNumber = $number;
                $endNumber = $number + 1;
                $next = '';
                break;
            } elseif ($currentDay < $number) {
                $startNumber = $number;
                $endNumber = $number + 1;
                $next = 'next ';
                break;
            } else {
                $startNumber = $number;
                $endNumber = $number + 1;
                $next = 'next ';
            }
        }

        $startDay = Mage::helper('dailydeals')->getNextDayNameWithNumber($startNumber, $next);
        $endDay = Mage::helper('dailydeals')->getNextDayNameWithNumber($endNumber, $next);
        $data = array();
        $data['deal_start_time'] = $startDay['date'];
        $data['deal_end_time'] = $endDay['date'];

        return $data;
    }

}