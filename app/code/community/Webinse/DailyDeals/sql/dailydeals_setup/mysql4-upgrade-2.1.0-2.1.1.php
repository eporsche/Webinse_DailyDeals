<?php
/**
 * mysql4-upgrade-2.1.0-2.1.1
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

$installer->addAttribute(
    'catalog_product', 'choice_type_dealstime', array(
        'type' => 'int',
        'label' => 'Choice type dealstime',
        'input' => 'select',
        'source' => 'eav/entity_attribute_source_boolean',
        'global' => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_GLOBAL,
        'visible' => false,
        'required' => false,
        'user_defined' => false,
        'default' => '1',
        'visible_on_front' => false,
        'apply_to' => 'downloadable,simple,virtual',

    )
);
$installer->addAttribute(
    'catalog_product', 'deal_update_days_product', array(
        'type' => 'varchar',
        'label' => 'Deal Products will be run and update each',
        'input' => 'multiselect',
        'global' => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_GLOBAL,
        'visible' => false,
        'required' => false,
        'user_defined' => true,
        'default' => "",
        'backend_model' => 'eav/entity_attribute_backend_array',
        'source' => 'Webinse_DailyDeals_Model_Entity_Attribute_Source_Days',
        'apply_to' => 'downloadable,simple,virtual',
    )
);


$entityTypeId = Mage::getModel('eav/entity')->setType('catalog_product')->getTypeId();

$attributeSetCollection = Mage::getResourceModel('eav/entity_attribute_set_collection')
    ->setEntityTypeFilter(Mage::getModel('catalog/product')->getResource()->getTypeId());

foreach ($attributeSetCollection as $set) {
    $installer->addAttributeToSet($entityTypeId, $set->getAttributeSetName(), '', 'choice_type_dealstime');
    $installer->addAttributeToSet($entityTypeId, $set->getAttributeSetName(), '', 'deal_update_days_product');
}

$installer->endSetup();