<?php

/**
 * Webinse_DailyDeals_Model_Cron
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
 * Webinse_DailyDeals_Model_Cron.
 * .
 *
 * @category  Webinse
 * @package   Webinse_DailyDeals
 * @author    Webinse Team <info@webinse.com>
 * @copyright 2015 Webinse Ltd. (https://www.webinse.com)
 * @license   The Open Software License 3.0
 * @link      http://opensource.org/licenses/OSL-3.0
 */
class Webinse_DailyDeals_Model_Cron
{
    /**
     * Update Deal category
     *
     * @return none
     */
    public function updateDealCategory()
    {
        $dealCategoryModel = Mage::getModel('dailydeals/dealCategory');
        //array With Categories of deal status set in $this->_dealCategoryAtt
        $allDealCategory = $dealCategoryModel->getAllDealCategory();
        if ($allDealCategory) {
            //array with category to update today
            $toDayUpdateCategory = $dealCategoryModel->getArrayUpdateCategory();
            if (!empty($toDayUpdateCategory)) {
                //update deal status on products
                $dealCategoryModel->updateCategoryDealStatusInProduct($toDayUpdateCategory);
            }
        }
    }

    /**
     * Update Deal product
     *
     * @return none
     */
    public function updateDealProduct()
    {
        $collection = Mage::getResourceModel('catalog/product_collection')
            ->addAttributeToSelect('*')
            ->addAttributeToFilter('deal_status', array("notnull" => true))
            ->addAttributeToFilter('deal_update_days_product', array('notnull' => true));
        $data_time = array();
        $productFromCategory = false;
        foreach ($collection as $product) {
            if ($product->getDealsChoiceCategory() != '1') {
                $data_time = Mage::getModel('dailydeals/dealProduct')
                    ->getUpdateProduct(explode(',', $product->getDealUpdateDaysProduct()));
                $product
                    ->setDealStartTime($data_time['deal_start_time'])
                    ->setDealEndTime($data_time['deal_end_time']);
            } else {
                $product->addData(
                    array(
                        'deal_status' => null,
                        'deal_statuses' => 'removed',
                        'deal_qty' => null,
                        'deal_price' => null,
                        'deal_start_time' => null,
                        'deal_end_time' => null,
                        'deal_bought' => null,
                        'deal_category_id' => null,
                        'deals_choice_category' => null,
                        'choice_type_dealstime' => null,
                        'deal_update_days_product' => null
                    )
                );
                $productFromCategory = true;
            }
            $product->save();
        }
        if ($productFromCategory) {
            $this->updateDealCategory();
        }
    }
}