<?php
/**
 * mysql4-upgrade-0.1.3-0.1.4
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

$installer->addAttribute(
    $entityTypeId, 'old_special_price', array(
        'type' => 'varchar',
        'backend' => '',
        'frontend' => '',
        'label' => 'Old special price',
        'note' => ' ',
        'input' => 'text',
        'class' => '',
        'source' => '',
        'global' => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_GLOBAL,
        'visible' => false,
        'required' => false,
        'user_defined' => false,
        'default' => '',
        'searchable' => false,
        'filterable' => false,
        'comparable' => false,
        'visible_on_front' => false,
        'unique' => false,
        'is_configurable' => false
    )
);
$installer->addAttribute(
    $entityTypeId, 'old_special_date_from', array(
        'type' => 'datetime',
        'backend' => '',
        'frontend' => '',
        'label' => 'Old special date from',
        'note' => ' ',
        'input' => 'date',
        'class' => '',
        'source' => '',
        'global' => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_GLOBAL,
        'visible' => false,
        'required' => false,
        'user_defined' => false,
        'default' => '',
        'searchable' => false,
        'filterable' => false,
        'comparable' => false,
        'visible_on_front' => false,
        'unique' => false,
        'is_configurable' => false
    )
);
$installer->addAttribute(
    $entityTypeId, 'old_special_date_to', array(
        'type' => 'datetime',
        'backend' => '',
        'frontend' => '',
        'label' => 'Old special date to',
        'note' => ' ',
        'input' => 'date',
        'class' => '',
        'source' => '',
        'global' => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_GLOBAL,
        'visible' => false,
        'required' => false,
        'user_defined' => false,
        'default' => '',
        'searchable' => false,
        'filterable' => false,
        'comparable' => false,
        'visible_on_front' => false,
        'unique' => false,
        'is_configurable' => false
    )
);

$attNames = array(
    'old_special_price',
    'old_special_date_from',
    'old_special_date_to'
);

$attributeSetCollection = Mage::getResourceModel('eav/entity_attribute_set_collection')
    ->setEntityTypeFilter(Mage::getModel('catalog/product')->getResource()->getTypeId());

foreach ($attributeSetCollection as $attribute) {
    foreach ($attNames as $attName) {
        $installer->addAttributeToSet($entityTypeId, $attribute->getAttributeSetName(), 'Daily Deals', $attName);
    }
}

$installer->endSetup();
