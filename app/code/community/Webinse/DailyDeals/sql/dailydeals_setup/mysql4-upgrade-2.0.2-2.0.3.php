<?php
/**
 * mysql4-upgrade-2.0.2-2.0.3
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
$installer = $this;
$installer->startSetup();
Mage::getModel('dailydeals/statuses')
    ->setData(
        array(
            'code' => 'automatically',
            'title' => 'Running Automatically',
        )
    )
    ->save();
$installer->endSetup();