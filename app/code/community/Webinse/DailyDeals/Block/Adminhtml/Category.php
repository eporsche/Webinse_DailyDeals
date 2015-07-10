<?php

/**
 * Webinse_DailyDeals_Block_Adminhtml_Category
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
 * Webinse_DailyDeals_Block_Adminhtml_Category.
 * .
 *
 * @category  Webinse
 * @package   Webinse_DailyDeals
 * @author    Webinse Team <info@webinse.com>
 * @copyright 2015 Webinse Ltd. (https://www.webinse.com)
 * @license   The Open Software License 3.0
 * @link      http://opensource.org/licenses/OSL-3.0
 */
class Webinse_DailyDeals_Block_Adminhtml_Category extends Mage_Adminhtml_Block_Widget_Grid_Container
{
    /**
     * Constructor
     */
    public function __construct()
    {
        //$this->_blockGroup = 'dealsCategoryGrid';
        $this->_blockGroup = 'dailydeals';
        $this->_controller = 'adminhtml_category';
        $this->_headerText = Mage::helper('dailydeals')->__('Deals Category');

        parent::__construct();
        $this->_removeButton('add');
        $this->_addButton(
            'add', array(
            'label' => 'Add New Category',
            'onclick' => 'setLocation(\'' . $this->getUrl('*/*/newCategory') . '\')',
            'class' => 'add',
            )
        );
    }

    /**
     * CSS
     *
     * @return string
     */
    public function getHeaderCssClass()
    {
        return 'icon-head head-products';
    }
}