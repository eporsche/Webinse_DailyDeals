<?php
/**
 * mysql4-upgrade-0.1.0-0.1.1
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
$table = $installer->getConnection()->newTable($installer->getTable('dailydeals/statuses'))
    ->addColumn(
        'entity_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'unsigned' => false,
        'nullable' => false,
        'primary' => false,
        'identity' => true,
    ), 'entity_id'
    )
    ->addColumn(
        'code', Varien_Db_Ddl_Table::TYPE_VARCHAR, 100, array(
        'nullable' => false,
    ), 'code'
    )
    ->addColumn(
        'title', Varien_Db_Ddl_Table::TYPE_VARCHAR, 100, array(
        'nullable' => true
    ), 'title '
    )
    ->addIndex(
        $installer->getIdxName('dailydeals/statuses', 'entity_id', Varien_Db_Adapter_Interface::INDEX_TYPE_UNIQUE),
        'entity_id',
        array(
            'type' => Varien_Db_Adapter_Interface::INDEX_TYPE_UNIQUE)
    )
    ->setComment('Webinse dailydeals/statuses');
$installer->getConnection()->createTable($table);

$values = array(
    array(
        'code' => 'pending',
        'title' => 'Pending',
    ),
    array(
        'code' => 'running',
        'title' => 'Running',
    ),
    array(
        'code' => 'ended',
        'title' => 'Ended',
    ),
);

foreach ($values as $value) {
    Mage::getModel('dailydeals/statuses')
        ->setData($value)
        ->save();
}

$installer->endSetup();