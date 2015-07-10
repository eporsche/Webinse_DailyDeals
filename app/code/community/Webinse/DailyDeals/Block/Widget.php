<?php

/**
 * Webinse_DailyDeals_Block_Widget
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
 * Webinse_DailyDeals_Block_Widget.
 * Widget Block
 *
 * @category  Webinse
 * @package   Webinse_DailyDeals
 * @author    Webinse Team <info@webinse.com>
 * @copyright 2015 Webinse Ltd. (https://www.webinse.com)
 * @license   The Open Software License 3.0
 * @link      http://opensource.org/licenses/OSL-3.0
 */
class Webinse_DailyDeals_Block_Widget
    extends Mage_Core_Block_Template
    implements Mage_Widget_Block_Interface
{

    /**
     * Return HTML
     *
     * @return mixed
     */
    protected function _toHtml()
    {
        $block = $this->getLayout()
            ->createBlock('dailydeals/product_list', null, $this->getData())
            ->setTemplate('deals/widget/link/widget.phtml');
        return $block->toHtml();
    }


}