<?php
/**
 * mysql4-upgrade-2.1.1-2.1.2
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
    'catalog_product', 'deals_choice_category', array(
        'type' => 'int',
        'label' => 'Deals choice from category',
        'input' => 'select',
        'source' => 'eav/entity_attribute_source_boolean',
        'global' => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_GLOBAL,
        'visible' => false,
        'required' => false,
        'user_defined' => false,
        'default' => '0',
        'visible_on_front' => false,
        'apply_to' => 'downloadable,simple,virtual',

    )
);


$entityTypeId = Mage::getModel('eav/entity')->setType('catalog_product')->getTypeId();

$attributeSetCollection = Mage::getResourceModel('eav/entity_attribute_set_collection')
    ->setEntityTypeFilter(Mage::getModel('catalog/product')->getResource()->getTypeId());

foreach ($attributeSetCollection as $set) {
    $installer->addAttributeToSet($entityTypeId, $set->getAttributeSetName(), '', 'deals_choice_category');
}

$installer->endSetup();