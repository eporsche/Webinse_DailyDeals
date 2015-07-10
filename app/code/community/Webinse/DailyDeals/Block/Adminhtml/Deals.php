<?php

/**
 * Webinse_DailyDeals_Block_Adminhtml_Deals
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
 * Webinse_DailyDeals_Block_Adminhtml_Deals.
 * Adminhtml deals
 *
 * @category  Webinse
 * @package   Webinse_DailyDeals
 * @author    Webinse Team <info@webinse.com>
 * @copyright 2015 Webinse Ltd. (https://www.webinse.com)
 * @license   The Open Software License 3.0
 * @link      http://opensource.org/licenses/OSL-3.0
 */
class Webinse_DailyDeals_Block_Adminhtml_Deals extends Mage_Adminhtml_Block_Widget_Grid_Container
{

    /**
     * Block constructor
     */
    public function __construct()
    {
        $this->_blockGroup = 'dailydeals';
        $this->_controller = 'adminhtml_deals';
        $this->_headerText = Mage::helper('dailydeals')->__('Deals');

        $this->_addButton(
            'add', array(
            'label'   => $this->getAddButtonLabel(),
            'onclick' => 'setLocation(\'' . $this->getCreateUrl() . '\')',
            'class'   => 'add',
            )
        );

        if (!Mage::getSingleton('admin/session')->isAllowed('*/*/create')) {
            $this->_removeButton('add');
        }

        if (is_null($this->_backButtonLabel)) {
            $this->_backButtonLabel = $this->__('Back');
        }

        parent::__construct();
    }

    /**
     * CSS class
     *
     * @return string
     */
    public function getHeaderCssClass()
    {
        return 'icon-head head-products';
    }

}