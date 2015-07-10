<?php

/**
 * Webinse_DailyDeals_Block_Adminhtml_Category_Categories
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

/**
 * Webinse_DailyDeals_Block_Adminhtml_Category_Categories.
 *
 * Adminhtml new deals grid
 *
 * @category  Webinse
 * @package   Webinse_DailyDeals
 * @author    Webinse Team <info@webinse.com>
 * @copyright 2015 Webinse Ltd. (https://www.webinse.com)
 * @license   The Open Software License 3.0
 * @link      http://opensource.org/licenses/OSL-3.0
 */
class Webinse_DailyDeals_Block_Adminhtml_Category_Categories extends Mage_Adminhtml_Block_Widget_Grid
{

    /**
     * Set some default on the grid
     */
    public function __construct()
    {
        parent::__construct();
        $this->setId('dealsCategoryGrid');
        $this->setDefaultSort('identifier');
        $this->setDefaultDir('ASC');
        $this->setUseAjax(true);
        //$this->setSaveParametersInSession(true);
    }

    /**
     * Set the desired collection on our grid
     *
     * @return Mage_Adminhtml_Block_Widget_Grid
     */

    protected function _prepareCollection()
    {
        $collection = Mage::getResourceModel('catalog/category_collection')
            ->addAttributeToSelect('*')
            ->addAttributeToFilter('name', array("nin" => array('Root Catalog', 'Default Category')))
            ->addAttributeToFilter('qty_deal_product', array("null" => true))
            ->addAttributeToFilter('deal_update_days', array("null" => true));
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }

    /**
     * Getting store info
     *
     * @return Mage_Core_Model_Store
     */
    protected function getStore()
    {
        $storeId = (int) $this->getRequest()->getParam('store', 0);
        return Mage::app()->getStore($storeId);
    }

    //$this->getCollection()->getSize()
    /**
     *  Set columns on our grid
     *
     * @return Mage_Adminhtml_Block_Widget_Grid
     */
    protected function _prepareColumns()
    {
        $store = $this->getStore();
        $helper = Mage::helper('dailydeals');

        $this->addColumn(
            'parent_category_name', array(
                'header' => $helper->__('Parent Category Name'),
                'width' => '150px',
                'index' => 'parent_category_name',
                'filter' => false,
                'sortable' => false,
                'renderer' => 'Webinse_DailyDeals_Block_Adminhtml_Category_Renderer_ParentCategory',
            )
        );

        $this->addColumn(
            'category_name', array(
                'header' => $helper->__('Category Name'),
                'index' => 'name',
            )
        );

        $this->addColumn(
            'is_active', array(
                'width' => '50px',
                'align' => 'center',
                'header' => $helper->__('Is Active'),
                'index' => 'is_active',
                'type' => 'options',
                'options' => array(
                    '1' => Mage::helper('catalog')->__('Active'),
                    '0' => Mage::helper('catalog')->__('Disabled')),

            )
        );

        $this->addColumn(
            'include_in_menu', array(
                'width' => '50px',
                'align' => 'center',
                'header' => $helper->__('Include in Navigation Menu'),
                'index' => 'include_in_menu',
                'type' => 'options',
                'options' => array(
                    '1' => Mage::helper('catalog')->__('Yes'),
                    '0' => Mage::helper('catalog')->__('No')),

            )
        );

        $this->addColumn(
            'view_deal_category', array(
                'width' => '50px',
                'header' => $helper->__('Add Category to Deal'),
                'type' => 'action',
                'getter' => 'getId',
                'filter' => false,
                'is_system' => true,
                'actions' => array(
                    array(
                        'caption' => $helper->__('Add Deal'),
                        'url' => array('base' => '*/*/editcategory/'),
                        'field' => 'entity_id')),
                'sortable' => false,
                //'index' => 'stores',
            )
        );

        return parent::_prepareColumns();
    }

    /**
     * Get url for row
     *
     * @param mixed $row row
     *
     * @return string
     */
    public function getRowUrl($row)
    {
        return $this->getUrl('*/*/editcategory', array('entity_id' => $row->getId()));
    }

    /**
     * Url for ajax
     *
     * @return string
     */
    public function getGridUrl()
    {
        return $this->getUrl('*/*/categories', array('_current' => true));
    }

}