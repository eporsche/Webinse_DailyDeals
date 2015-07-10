<?php

/**
 * Webinse_DailyDeals_Block_Adminhtml_Deals_Grid
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
 * Webinse_DailyDeals_Block_Adminhtml_Deals_Grid.
 * Adminhtml Deals Grid
 *
 * @category  Webinse
 * @package   Webinse_DailyDeals
 * @author    Webinse Team <info@webinse.com>
 * @copyright 2015 Webinse Ltd. (https://www.webinse.com)
 * @license   The Open Software License 3.0
 * @link      http://opensource.org/licenses/OSL-3.0
 */
class Webinse_DailyDeals_Block_Adminhtml_Deals_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
    /**
     * Set some default on the grid
     */
    public function __construct()
    {
        parent::__construct();
        $this->setId('dealsGrid');
        $this->setDefaultSort('identifier');
        $this->setDefaultDir('ASC');
        $this->setUseAjax(true);
        $this->setSaveParametersInSession(true);
    }

    /**
     * Statuses updater
     *
     * @return none
     */
    private function updateDealsStatuses()
    {
        $helper = Mage::helper('dailydeals');
        $collection = Mage::getResourceModel('catalog/product_collection')
            ->addAttributeToSelect('*')
            ->addAttributeToFilter('deal_status', true);
        foreach ($collection as $item) {
            if ($item->getDealStatus()) {
                $stat = Mage::helper('dailydeals')->checkUpdateDealStatus($item);
                if ($stat != $item->getDealStatuses()) {
                    $helper->changeSpecialData($item, $stat);
                    $item->setDealStatuses($stat)->save();
                }
            }
        }
    }

    /**
     * Get store info
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
        $tableName = Mage::getSingleton('core/resource')->getTableName('dailydeals/statuses');
        $this->updateDealsStatuses();
        $collection = Mage::getResourceModel('catalog/product_collection')
            ->addAttributeToSelect('*')
            ->addAttributeToFilter('deal_status', array("notnull" => true));

        $collection->joinAttribute('deal_statuses', 'catalog_product/deal_statuses', 'entity_id', null, 'inner');
        $collection->getSelect()->joinLeft(
            $tableName, 'at_deal_statuses.value = ' . $tableName . '.code', array(
            'deal_statuses' => 'title',
            )
        );
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }

    /**
     * Columns
     *
     * @return Mage_Adminhtml_Block_Widget_Grid
     */
    protected function _prepareColumns()
    {
        $store = $this->getStore();
        $helper = Mage::helper('dailydeals');
        $this->addColumn(
            'product_name', array(
            'header' => $helper->__('Product Name'),
            'index' => 'name',
            )
        );

        $this->addColumn(
            'product_sku', array(
            'header' => $helper->__('Product Sku'),
            'index' => 'sku',
            )
        );

        $this->addColumn(
            'type', array(
                'header' => $helper->__('Type'),
                'index' => 'type_id',
                'type' => 'options',
                'options' => array(
                    'simple' => Mage::helper('catalog')->__('Simple Product'),
                    'downloadable' => Mage::helper('catalog')->__('Downloadable Product'),
                    'virtual' => Mage::helper('catalog')->__('Virtual Product')
                )
            )
        );

        $this->addColumn(
            'price', array(
            'header' => $helper->__('Price'),
            'currency_code' => $store->getBaseCurrency()->getCode(),
            'type' => 'price',
            'index' => 'price',
            )
        );

        $this->addColumn(
            'deal_price', array(
            'header' => $helper->__('Deal price'),
            'type' => 'price',
            'currency_code' => $store->getBaseCurrency()->getCode(),
            'index' => 'deal_price',
            )
        );

        $this->addColumn(
            'deal_qty', array(
            'header' => $helper->__('Deal Quantity'),
            'type' => 'number',
            'index' => 'deal_qty',
            )
        );

        $this->addColumn(
            'deal_bought', array(
            'header' => $helper->__('Deal Bought'),
            'type' => 'number',
            'index' => 'deal_bought',
            )
        );

        $this->addColumn(
            'deal_start_time', array(
            'header' => $helper->__('Deal Start'),
            'align' => 'left',
            'type' => 'date',
            'index' => 'deal_start_time',
            'width' => '165px',
            )
        );

        $this->addColumn(
            'deal_end_time', array(
            'header' => $helper->__('Deal End'),
            'align' => 'left',
            'type' => 'date',
            'index' => 'deal_end_time',
            'width' => '165px',
            )
        );

        $this->addColumn(
            'deal_statuses', array(
            'header' => $helper->__('Deal Status'),
            'type' => 'options',
            'index' => 'deal_statuses',
            'options' => Mage::getSingleton('dailydeals/statuses')->getOptionsStatusArray(),
            'renderer' => 'Webinse_DailyDeals_Block_Adminhtml_Widget_Grid_Column_Renderer_Status',
            'align' => 'center'
            )
        );

        $this->addColumn(
            'view_deal_product', array(
            'header' => $helper->__('Edit'),
            'type' => 'action',
            'getter' => 'getId',
            'filter' => false,
            'sortable' => false,
            'is_system' => true,
            'actions' => array(
                array(
                    'caption' => $helper->__('Edit'),
                    'url' => array('base' => '*/*/edit/'),
                    'field' => 'id')),
            )
        );

        $this->addColumn(
            'view_product', array(
            'header' => $helper->__('View Product'),
            'width' => '100',
            'type' => 'action',
            'getter' => 'getId',
            'filter' => false,
            'sortable' => false,
            'is_system' => true,
            'actions' => array(
                array(
                    'caption' => $helper->__('View Product'),
                    'url' => array('base' => '*/catalog_product/edit/'),
                    'field' => 'id')),
            )
        );

        return parent::_prepareColumns();
    }

    /**
     * Mass action
     *
     * @return $this
     */
    protected function _prepareMassaction()
    {
        $this->setMassactionIdField('entity_id');
        $this->getMassactionBlock()->setFormFieldName('banners');

        $this->getMassactionBlock()->addItem(
            'status', array(
            'label' => Mage::helper('adminhtml')->__('Change status'),
            'url' => $this->getUrl('*/*/massStatus', array('_current' => true)),
            'additional' => array(
                'visibility' => array(
                    'name' => 'status',
                    'type' => 'select',
                    'class' => 'required-entry',
                    'label' => Mage::helper('adminhtml')->__('Status'),
                    'values' => Mage::getModel('dailydeals/System_Config_Source_Enabling')->toArray()
                    )
                )
            )
        );
        $this->getMassactionBlock()->addItem(
            'remove', array(
            'label' => Mage::helper('adminhtml')->__('Remove deal status'),
            'url' => $this->getUrl('*/*/massRemove'),
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
        return $this->getUrl('*/*/edit', array('id' => $row->getId()));
    }
    /**
     * Css
     *
     * @return string
     */
    public function getGridUrl()
    {
        return $this->getUrl('*/*/grid', array('_current' => true));
    }
}