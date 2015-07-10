<?php
/**
 * mysql4-upgrade-0.1.1-0.1.2
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
    $entityTypeId, 'deal_statuses', array(
        'type' => 'varchar',
        'backend' => '',
        'frontend' => '',
        'label' => 'Deal Statuses',
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

$attributeSetCollection = Mage::getResourceModel('eav/entity_attribute_set_collection')
    ->setEntityTypeFilter(Mage::getModel('catalog/product')->getResource()->getTypeId());

foreach ($attributeSetCollection as $attribute) {
    $installer->addAttributeToSet($entityTypeId, $attribute->getAttributeSetName(), 'Daily Deals', 'deal_statuses');
}

$installer->endSetup();
