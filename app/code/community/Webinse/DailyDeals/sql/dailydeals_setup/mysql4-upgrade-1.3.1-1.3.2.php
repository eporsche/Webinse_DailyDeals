<?php

/**
 * mysql4-upgrade-1.3.1-1.3.2
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
$installer = new Mage_Catalog_Model_Resource_Setup('core_setup');
$installer->startSetup();
$entityTypeId = Mage::getModel('eav/entity')
    ->setType('catalog_product')
    ->getTypeId();
$attributesCode = array(
    'deal_price',
    'deal_start_time',
    'deal_end_time',
    'deal_qty',
    'deal_bought',
    'deal_status',
    'deal_statuses',
    'old_special_price',
    'old_special_date_from',
    'old_special_date_to',
);
foreach ($attributesCode as $attribute) {
    $installer->updateAttribute($entityTypeId, $attribute, 'apply_to', 'downloadable,simple,virtual');
}
$installer->endSetup();