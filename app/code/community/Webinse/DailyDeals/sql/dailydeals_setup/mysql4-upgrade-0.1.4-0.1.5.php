<?php

/**
 * mysql4-upgrade-0.1.4-0.1.5
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


$installer = new Mage_Sales_Model_Resource_Setup('core_setup');
$conn = $installer->getConnection();
$installer->addAttribute('order_item', 'deal_stat', array());
