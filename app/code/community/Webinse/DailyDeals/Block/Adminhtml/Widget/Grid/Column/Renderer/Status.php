<?php

/**
 * Webinse_DailyDeals_Block_Adminhtml_Widget_Grid_Column_Renderer_Status
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
 * Webinse_DailyDeals_Block_Adminhtml_Widget_Grid_Column_Renderer_Status.
 * Renderer deal's status row
 *
 * @category  Webinse
 * @package   Webinse_DailyDeals
 * @author    Webinse Team <info@webinse.com>
 * @copyright 2015 Webinse Ltd. (https://www.webinse.com)
 * @license   The Open Software License 3.0
 * @link      http://opensource.org/licenses/OSL-3.0
 */
class Webinse_DailyDeals_Block_Adminhtml_Widget_Grid_Column_Renderer_Status
    extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract
{
    /**
     * render status
     *
     * @param Varien_Object $row row
     *
     * @return string
     */
    public function render(Varien_Object $row)
    {
        switch ($row->getDealStatuses()) {
            case 'Disabled':
                return '<div class="disabled_deal">DISABLED</div>';
                break;
            case 'Pending':
                return '<div class="pending">PENDING</div>';
                break;
            case 'Running':
                return '<div class="running">RUNNING</div>';
                break;
            case 'Ended':
                return '<div class="ended">ENDED</div>';
                break;
            case 'Running Automatically':
                return '<div class="automatically">RUNNING AUTOMATICALLY</div>';
                break;
        }
    }

}