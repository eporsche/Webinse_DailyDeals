<?php
/**
 * data-upgrade-1.3.1-1.3.2
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
$params = array(
    'numbers_item' => 2,
    'border_size' => 1,
    'border_style' => 'solid',
    'border_color' => '#ffffff',
    'countdown_color' => '#2e8ab8',
    'countdown_width' => 180,
    'countdown_height' => 40,
);
$pageGroups = array(array(
    'page_group' => 'all_pages',
    'all_pages' => array(
        'page_id' => null,
        'group' => 'all_pages',
        'layout_handle' => 'default',
        'block' => 'left',
        'for' => 'all',
        'template' => '',
    )
));
$model = Mage::getModel('widget/widget_instance');
$widget = $model->getCollection()->addFieldToFilter('instance_type', array('dailydeals/widget'))->getData();
$widgetId = $widget[0]['instance_id'];
$updateWidget = $model->load($widgetId)
    ->setWidgetParameters(serialize($params))
    ->setPageGroups($pageGroups)
    ->save();

$installer->endSetup();