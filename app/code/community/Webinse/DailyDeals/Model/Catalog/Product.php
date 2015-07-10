<?php

/**
 * Webinse_DailyDeals_Model_Catalog_Product
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
 * Webinse_DailyDeals_Model_Catalog_Product.
 *
 * Catalog product
 *
 * @category  Webinse
 * @package   Webinse_DailyDeals
 * @author    Webinse Team <info@webinse.com>
 * @copyright 2015 Webinse Ltd. (https://www.webinse.com)
 * @license   The Open Software License 3.0
 * @link      http://opensource.org/licenses/OSL-3.0
 */
class Webinse_DailyDeals_Model_Catalog_Product extends Mage_Catalog_Model_Product
{
    /**
     * Retrieve array of custom products
     *
     * @return array
     */
    public function getCustomProducts()
    {
        if (!$this->hasCustomProducts()) {
            $products = array();
            $collection = $this->getCustomProductCollection();
            foreach ($collection as $product) {
                $products[] = $product;
            }
            $this->setCustomProducts($products);
        }
        return $this->getData('custom_products');
    }
    /**
     * Retrieve custom products identifiers
     *
     * @return array
     */
    public function getCustomProductIds()
    {
        if (!$this->hasCustomProductIds()) {
            $ids = array();
            foreach ($this->getCustomProducts() as $product) {
                $ids[] = $product->getId();
            }
            $this->setCustomProductIds($ids);
        }
        return $this->getData('custom_product_ids');
    }
    /**
     * Retrieve collection custom product
     *
     * @return Mage_Catalog_Model_Resource_Product_Link_Product_Collection
     */
    public function getCustomProductCollection()
    {
        $collection = $this->getLinkInstance()->useCustomLinks()
            ->getProductCollection()
            ->setIsStrongMode();
        $collection->setProduct($this);
        return $collection;
    }
    /**
     * Retrieve collection custom link
     *
     * @return Mage_Catalog_Model_Resource_Product_Link_Collection
     */
    public function getCustomLinkCollection()
    {
        $collection = $this->getLinkInstance()->useCustomLinks()
            ->getLinkCollection();
        $collection->setProduct($this);
        $collection->addLinkTypeIdFilter();
        $collection->addProductIdFilter();
        $collection->joinAttributes();
        return $collection;
    }
}