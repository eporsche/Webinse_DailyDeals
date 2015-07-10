<?php

/**
 * Webinse_DailyDeals_Block_Adminhtml_Category_Grid
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
 * Webinse_DailyDeals_Block_Adminhtml_Category_Grid.
 * .
 *
 * @category  Webinse
 * @package   Webinse_DailyDeals
 * @author    Webinse Team <info@webinse.com>
 * @copyright 2015 Webinse Ltd. (https://www.webinse.com)
 * @license   The Open Software License 3.0
 * @link      http://opensource.org/licenses/OSL-3.0
 */
class Webinse_DailyDeals_Block_Adminhtml_Category_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
    /**
     * Simple constructor
     */
    public function __construct()
    {
        parent::__construct();
        $this->setId('dealsCategoryGrid');
        $this->_controller = 'adminhtml_deals';
        $this->setDefaultSort('identifier');
        $this->setDefaultDir('ASC');
        $this->setUseAjax(true);
        $this->setSaveParametersInSession(true);
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

    /**
     * Set the desired collection on our grid
     *
     * @return Mage_Adminhtml_Block_Widget_Grid
     */
    protected function _prepareCollection()
    {
        $collection = Mage::getResourceModel('catalog/category_collection')
            ->addAttributeToSelect('*')
            ->addAttributeToFilter('deal_update_days', array("notnull" => true));

        $this->setCollection($collection);
        return parent::_prepareCollection();
    }

    /**
     * Columns preparation
     *
     * @return $this
     */
    protected function _prepareColumns()
    {
        $store = $this->getStore();
        $helper = Mage::helper('dailydeals');
        $this->addColumn(
            'parent_category_name', array(
                'header' => $helper->__('Parent Category Name'),
                'width' => '60px',
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
            'qty_deal_product', array(
                'header' => $helper->__('Qty Deals Products'),
                'index' => 'qty_deal_product',
            )
        );

        $this->addColumn(
            'deal_update_days', array(
                'header' => $helper->__('Deal Update Days'),

                'index' => 'deal_update_days',

                'renderer' => 'Webinse_DailyDeals_Block_Adminhtml_Widget_Grid_Column_Renderer_Days',
                'align' => 'center'
            )
        );
        $this->addColumn(
            'view_deal_category', array(
                'width' => '50px',
                'header' => $helper->__('Edit'),
                'type' => 'action',
                'getter' => 'getId',
                'filter' => false,
                'sortable' => false,
                'is_system' => true,
                'actions' => array(
                    array(
                        'caption' => $helper->__('Edit'),
                        'url' => array('base' => '*/*/editcategory/'),
                        'field' => 'entity_id')),
            )
        );
        $this->addColumn(
            'view_category', array(
                'width' => '50px',
                'header' => $helper->__('View Category'),
                'type' => 'action',
                'getter' => 'getId',
                'filter' => false,
                'sortable' => false,
                'is_system' => true,
                'actions' => array(
                    array(
                        'caption' => $helper->__('Category'),
                        'url' => array('base' => '*/catalog_category/'),
                        'field' => 'entity_id')),
            )
        );
        return parent::_prepareColumns();

    }

    /**
     * Mass action
     *
     * @return $this
     */
    protected function _prepareMassAction()
    {
        $this->setMassactionIdField('entity_id');
        $this->getMassactionBlock()->setFormFieldName('category_deals_remove');
        $this->getMassactionBlock()->addItem(
            'remove_cat', array(
                'label' => Mage::helper('adminhtml')->__('Remove deal status'),
                'url' => $this->getUrl('*/*/massRemoveCat'),
            )
        );
        return $this;
    }

    /**
     * Row URL
     *
     * @param mixed $row row
     *
     * @return string
     */
    public function getRowUrl($row)
    {
        return $this->getUrl('*/*/editcategory/', array('entity_id' => $row->getId()));
    }
    /**
     * Url for ajax
     *
     * @return string
     */
    public function getGridUrl()
    {
        return $this->getUrl('*/*/gridcategory', array('_current'=>true));
    }
}