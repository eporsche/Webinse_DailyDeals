<?php
/**
 * Webinse_DailyDeals_Block_Adminhtml_Category_Renderer_ParentCategory
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
 * Webinse_DailyDeals_Block_Adminhtml_Category_Renderer_ParentCategory.
 *
 * Adminhtml
 *
 * @category  Webinse
 * @package   Webinse_DailyDeals
 * @author    Webinse Team <info@webinse.com>
 * @copyright 2015 Webinse Ltd. (https://www.webinse.com)
 * @license   The Open Software License 3.0
 * @link      http://opensource.org/licenses/OSL-3.0
 */
class Webinse_DailyDeals_Block_Adminhtml_Category_Renderer_ParentCategory extends
    Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract
{
    /**
     * Render category
     *
     * @param Varien_Object $row object
     * @return string
     */
    public function render(Varien_Object $row)
    {
        $categoryId = $row->getId();
        $collection = Mage::getResourceModel('catalog/category_collection');

        foreach ($collection as $value) {
            if ($value->getId() == $categoryId) {
                $parentName = $value->getParentCategory()->getName();

                return $parentName;
            }
        }
    }
}