<?php
/**
 * Webinse_DailyDeals_Block_Links
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
 * Webinse_DailyDeals_Block_Links.
 * AddDealsLink Block
 *
 * @category  Webinse
 * @package   Webinse_DailyDeals
 * @author    Webinse Team <info@webinse.com>
 * @copyright 2015 Webinse Ltd. (https://www.webinse.com)
 * @license   The Open Software License 3.0
 * @link      http://opensource.org/licenses/OSL-3.0
 */
class Webinse_DailyDeals_Block_Links extends Mage_Core_Block_Template
{
    /**
     * add links
     *
     * @return $this
     */
    public function addDealLink()
    {
        $parentBlock = $this->getParentBlock();
        $text = $this->helper('dailydeals')->getDealsConfig('dailydeals_group/label_deals_link');
        $parentBlock->addLink($text, 'dailydeals/', $text, true, array(), 1, null, 'class="top-link-deals"');

        return $this;
    }
}