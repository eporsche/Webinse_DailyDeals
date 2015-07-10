<?php
/**
 * Webinse_DailyDeals_Model_Page
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
 * Webinse_DailyDeals_Model_Page.
 * Page model
 *
 * @category  Webinse
 * @package   Webinse_DailyDeals
 * @author    Webinse Team <info@webinse.com>
 * @copyright 2015 Webinse Ltd. (https://www.webinse.com)
 * @license   The Open Software License 3.0
 * @link      http://opensource.org/licenses/OSL-3.0
 */
class Webinse_DailyDeals_Model_Page extends Mage_Core_Model_Abstract
{
    /**
     * Initialize resource model

     */
    protected function _construct()
    {
        $this->_init('cms/page');
    }

    /**
     * Prepare page's statuses.
     * Available event cms_page_get_deals_statuses to customize statuses.
     *
     * @return array
     */
    public function getDealsStatuses()
    {
        $statuses = new Varien_Object(
            array(
                'running' => Mage::helper('adminhtml')->__('Running'),
                'ended' => Mage::helper('adminhtml')->__('Ended'),
                'suspended' => Mage::helper('adminhtml')->__('Pending'),
                'pending' => Mage::helper('adminhtml')->__('Suspend'),
            )
        );

        Mage::dispatchEvent('webinse_page_get_available_statuses', array('statuses' => $statuses));

        return $statuses->getData();
    }
}
