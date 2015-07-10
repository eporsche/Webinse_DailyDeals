<?php
/**
 * mysql4-upgrade-2.0.0-2.0.1
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
    ->setType('catalog_category')
    ->getTypeId();

$installer->addAttribute(
    $entityTypeId, 'deal_update_days', array(
        'type' => 'varchar',
        'label' => 'Deal Products will be run and update each',
        'input' => 'multiselect',
        'global' => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_GLOBAL,
        'visible' => true,
        'required' => false,
        'user_defined' => true,
        'default' => "",
        'group' => "General Information",
        'backend_model' => 'eav/entity_attribute_backend_array',
        'source' => 'Webinse_DailyDeals_Model_Entity_Attribute_Source_Days'
    )
);


$installer->addAttribute(
    $entityTypeId, 'qty_deal_product', array(
        'type' => 'int',
        'label' => 'Qty Deal Products in Category',
        'input' => 'text',
        'global' => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_GLOBAL,
        'visible' => true,
        'required' => false,
        'user_defined' => true,
        'default' => "",
        'group' => "General Information"

    )
);
$attributesCode = array(
    'qty_deal_product',
    'deal_update_days',
);

$attributeSetCollection = Mage::getResourceModel('eav/entity_attribute_set_collection')
    ->setEntityTypeFilter(Mage::getModel('catalog/category')->getResource()->getTypeId());

foreach ($attributeSetCollection as $attribute) {
    $name = $attribute->getAttributeSetName();
    $installer->addAttributeGroup($entityTypeId, $name, 'Daily Deals', 100);

    foreach ($attributesCode as $code) {
        $installer->addAttributeToSet($entityTypeId, $name, 'Daily Deals', $code);
    }
}

$installer->endSetup();