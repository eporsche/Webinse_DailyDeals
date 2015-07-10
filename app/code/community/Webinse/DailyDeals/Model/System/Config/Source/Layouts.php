<?php
/**
 * Webinse_DailyDeals_Model_System_Config_Source_Layouts
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
 * Webinse_DailyDeals_Model_System_Config_Source_Layouts.
 * Model with options "Deals Layout"
 *
 * @category  Webinse
 * @package   Webinse_DailyDeals
 * @author    Webinse Team <info@webinse.com>
 * @copyright 2015 Webinse Ltd. (https://www.webinse.com)
 * @license   The Open Software License 3.0
 * @link      http://opensource.org/licenses/OSL-3.0
 */
class Webinse_DailyDeals_Model_System_Config_Source_Layouts extends Mage_Core_Model_Abstract
{
    protected $_options = null;

    /**
     * Return array of options
     *
     * @return array|null
     */
    public function toOptionArray()
    {
        if ($this->_options === null) {
            $this->_options = array();
            foreach (Mage::getSingleton('page/config')->getPageLayouts() as $layout) {
                $this->_options[] = array(
                    'value' => $layout->getTemplate(),
                    'label' => $layout->getLabel(),
                );
            }
        }
        return $this->_options;
    }
}