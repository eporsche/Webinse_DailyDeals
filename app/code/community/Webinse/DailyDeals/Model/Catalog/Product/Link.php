<?php

/**
 * Webinse_DailyDeals_Model_Catalog_Product_Link
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
 * Webinse_DailyDeals_Model_Catalog_Product_Link.
 *
 * Product link
 *
 * @category  Webinse
 * @package   Webinse_DailyDeals
 * @author    Webinse Team <info@webinse.com>
 * @copyright 2015 Webinse Ltd. (https://www.webinse.com)
 * @license   The Open Software License 3.0
 * @link      http://opensource.org/licenses/OSL-3.0
 */
class Webinse_DailyDeals_Model_Catalog_Product_Link extends Mage_Catalog_Model_Product_Link
{
    const LINK_TYPE_CUSTOM   = 6;
    /**
     * Custom link
     *
     * @return Mage_Catalog_Model_Product_Link
     */
    public function useCustomLinks()
    {
        $this->setLinkTypeId(self::LINK_TYPE_CUSTOM);
        return $this;
    }
    /**
     * Save data for product relations
     *
     * @param Mage_Catalog_Model_Product $product product object
     *
     * @return  Mage_Catalog_Model_Product_Link
     */
    public function saveProductRelations($product)
    {
        parent::saveProductRelations($product);
        $data = $product->getCustomLinkData();
        if (!is_null($data)) {
            $this->_getResource()->saveProductLinks($product, $data, self::LINK_TYPE_CUSTOM);
        }
    }

}