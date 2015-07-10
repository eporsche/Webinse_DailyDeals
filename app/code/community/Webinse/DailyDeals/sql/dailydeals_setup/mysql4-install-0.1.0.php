<?php

/**
 * mysql4-install-0.1.0
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
    $entityTypeId, 'deal_price', array(
        'type' => 'varchar',
        'backend' => '',
        'frontend' => '',
        'label' => 'Deal Price',
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
    $entityTypeId, 'deal_start_time', array(
        'type' => 'datetime',
        'backend' => '',
        'frontend' => '',
        'label' => 'Deal Start Time',
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
    $entityTypeId, 'deal_end_time', array(
        'type' => 'datetime',
        'backend' => '',
        'frontend' => '',
        'label' => 'Deal End Time',
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
    $entityTypeId, 'deal_qty', array(
        'label' => 'Deal Qty',
        'type' => 'int',
        'input' => 'text',
        'source' => '',
        'global' => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_GLOBAL,
        'visible' => false,
        'required' => false,
        'user_defined' => true,
        'searchable' => true,
        'filterable' => true,
        'filterable_in_search' => true,
        'comparable' => true,
        'visible_on_front' => false,
        'visible_in_advanced_search' => false,
        'unique' => false,
    )
);


$installer->addAttribute(
    $entityTypeId, 'deal_bought', array(
        'label' => 'Deal Bought',
        'type' => 'int',
        'input' => 'text',
        'source' => '',
        'global' => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_GLOBAL,
        'visible' => false,
        'required' => false,
        'user_defined' => true,
        'searchable' => true,
        'default' => '0',
        'filterable' => true,
        'filterable_in_search' => true,
        'comparable' => true,
        'visible_on_front' => false,
        'visible_in_advanced_search' => false,
        'unique' => false,
    )
);


$installer->addAttribute(
    $entityTypeId, 'deal_status', array(
        'label' => 'Deal Status',
        'type' => 'int',
        'input' => 'boolean',
        'source' => '',
        'global' => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_GLOBAL,
        'visible' => false,
        'required' => false,
        'user_defined' => true,
        'searchable' => true,
        'filterable' => true,
        'filterable_in_search' => true,
        'comparable' => true,
        'visible_on_front' => false,
        'visible_in_advanced_search' => false,
        'unique' => false,
    )
);

$attributesCode = array(
    'deal_price',
    'deal_start_time',
    'deal_end_time',
    'deal_qty',
    'deal_bought',
    'deal_status'
);


$attributeSetCollection = Mage::getResourceModel('eav/entity_attribute_set_collection')
    ->setEntityTypeFilter(Mage::getModel('catalog/product')->getResource()->getTypeId());

foreach ($attributeSetCollection as $attribute) {
    $name = $attribute->getAttributeSetName();
    $installer->addAttributeGroup($entityTypeId, $name, 'Daily Deals', 100);

    foreach ($attributesCode as $code) {
        $installer->addAttributeToSet($entityTypeId, $name, 'Daily Deals', $code);
    }
}

$installer->endSetup();
