<?php

/**
 * Webinse_DailyDeals_Model_Observer
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
 * Webinse_DailyDeals_Model_Observer.
 * .
 *
 * @category  Webinse
 * @package   Webinse_DailyDeals
 * @author    Webinse Team <info@webinse.com>
 * @copyright 2015 Webinse Ltd. (https://www.webinse.com)
 * @license   The Open Software License 3.0
 * @link      http://opensource.org/licenses/OSL-3.0
 */
class Webinse_DailyDeals_Model_Observer
{

    /**
     * Check status product when data save
     *
     * @param Varien_Event_Observer $observer observed object
     */
    public function catalogProductSaveBefore(Varien_Event_Observer $observer)
    {
        $customFieldValue = $this->_getRequest()->getPost();
        $product = $observer->getProduct();
        $helper = Mage::helper('dailydeals');
        if (($customFieldValue['deal_status']) != null) {
            $setDealStatus = true;
            $setDealStatuses = true;
            if ($customFieldValue['deal_status'] == '0') {
                $setDealStatuses = 'Disabled';
                $setDealStatus = false;
            }

            if ($customFieldValue['choice_type_dealstime']) {
                $data_time = Mage::getModel('dailydeals/dealProduct')
                    ->getUpdateProduct($customFieldValue['deal_update_days_product']);
                $customFieldValue['deal_start_time'] = $data_time['deal_start_time'];
                $customFieldValue['deal_end_time'] = $data_time['deal_end_time'];
                $multiSelectArray = $customFieldValue['deal_update_days_product'];
                if (!empty($multiSelectArray)) {
                    $multiSelectStr = implode(",", $multiSelectArray);
                }
            }
            //convert date from locale to international format
            //$customFieldValue = $helper->_filterDates($customFieldValue, array('deal_start_time', 'deal_end_time'));

            $product->addData(
                array(
                'deal_status' => $setDealStatus,
                'deal_statuses' => $setDealStatuses,
                'deal_price' => $customFieldValue['deal_price'],
                'deal_update_days_product' => $multiSelectStr,
                'choice_type_dealstime' => $customFieldValue['choice_type_dealstime'],
                'deal_qty' => $customFieldValue['deal_qty'],
                'deal_start_time' => $customFieldValue['deal_start_time'],
                'deal_end_time' => $customFieldValue['deal_end_time']
            )
            );
        }
        if ((($product->getDealStatuses() == 'Disabled')) && ($product->getDealPrice())) {
            /***
             * If deal disabled
             */
            $helper->returnSpecialDataWhenStatusesDisabled($product);
        }
    }

    /**
     * Check deal_status when using product collection
     *
     * @param Varien_Event_Observer $observer observed object
     */
    public function catalogBlockProductListCollection(Varien_Event_Observer $observer)
    {
        $observer->getCollection()->addAttributeToSelect('*');
    }

    /**
     * Output notice in catalog_product
     *
     * @param Varien_Event_Observer $observer observed object
     *
     * @return Mage_Core_Model_Session_Abstract
     */
    public function catalogProductEditFormRenderRecurring(Varien_Event_Observer $observer)
    {
        $product = $observer->getProduct();
        if (($product->getDealStatuses() == 'running') || ($product->getDealStatuses() == 'automatically')) {
            if (($product->getOldSpecialDateFrom()) || ($product->getOldSpecialDateTo()) || ($product->getOldSpecialPrice() != '-')) {
                return Mage::getSingleton('adminhtml/session')
                    ->addNotice('Now activated the "Daily Deals" for this product. While it is activated you can not use standard special price. When "Daily Deals" will end will be returned your special data: <br/>special price: '
                        . $product->getOldSpecialPrice() . ' <br/>special date from: ' . $product->getOldSpecialDateFrom() . ' <br/>special date to: ' . $product->getOldSpecialDateTo());
            }
            return Mage::getSingleton('adminhtml/session')
                ->addNotice('Now activated the "Daily Deals" for this product. While it is activated you can not use standard special price.');
        }

    }

    /**
     * set deal_qty and deal_bought when create order
     *
     * @param Varien_Event_Observer $observer observed object
     */
    public function salesOrderPlaceAfter(Varien_Event_Observer $observer)
    {
        $helper = Mage::helper('dailydeals');
        Mage::app()->setCurrentStore(Mage_Core_Model_App::ADMIN_STORE_ID);
        $model = Mage::getModel('catalog/product');
        $orderItems = $observer->getOrder()->getQuote()->getAllItems();
        $this->setDealStat($observer);
        foreach ($orderItems as $orderItem) {
            $product = $model->load($orderItem->getProductId());
            if ($helper->isDealEnabled($product)) {
                $product->setDealQty($product->getDealQty() - $orderItem->getQuote()->getItemsQty())
                    ->setDealBought($product->getDealBought() + $orderItem->getQuote()->getItemsQty())
                    ->save();
            }
        }
    }

    /**
     * set deal_stat in order_item
     *
     * @param Varien_Event_Observer $observer observed object
     */
    protected function setDealStat($observer)
    {
        $model = Mage::getModel('catalog/product');
        $helper = Mage::helper('dailydeals');
        $items = $observer->getOrder()->getAllItems();
        foreach ($items as $item) {
            $product = $model->load($item->getProductId());
            if ($helper->isDealEnabled($product)) {
                $item->setDealStat(true);
            }
        }
    }

    /**
     * Set available quantity to quote item
     *
     * @param Varien_Event_Observer $observer observed object
     */
    public function checkoutCartSaveBefore(Varien_Event_Observer $observer)
    {
        $model = Mage::getModel('catalog/product');
        $helper = Mage::helper('dailydeals');
        $cartItems = $observer->getCart()->getItems();
        foreach ($cartItems as $cartItem) {
            $product = $model->load($cartItem->getProductId());
            if ($helper->isDealEnabled($product)) {
                if ($product->getDealQty() < $cartItem->getQty()) {
                    $cartItem->setQty($product->getDealQty());
                    Mage::getSingleton('core/session')->addError($helper->__('Only ' . $product->getDealQty() . ' deal "' . $product->getName() . '" left.'));
                }
            }
        }
    }

    /**
     * Change deal_qty and deal_bought when item cancel
     *
     * @param Varien_Event_Observer $observer observed object
     */
    public function salesOrderItemCancel(Varien_Event_Observer $observer)
    {
        $item = $observer->getItem();
        if ($item->getDealStat()) {
            $product = Mage::getModel('catalog/product')->load($item->getProductId());
            $product->setDealQty($product->getDealQty() + $item->getQtyOrdered())
                ->setDealBought($product->getDealBought() - $item->getQtyOrdered())
                ->save();
        }

    }

    /**
     * Change deal_qty and deal_bought if refound Credit memo
     *
     * @param Varien_Event_Observer $observer observed object
     */
    public function salesOrderCreditmemoRefund(Varien_Event_Observer $observer)
    {
        $arguments = $this->_getRequest()->getParam('creditmemo');
        $modelOrderItem = Mage::getModel('sales/order_item');
        $modelProduct = Mage::getModel('catalog/product');
        $items = $observer->getCreditmemo()->getAllItems();
        foreach ($items as $item) {
            $orderItem = $modelOrderItem->load($item->getOrderItemId());
            if ($orderItem->getDealStat()) {
                $qty = $orderItem->getQtyOrdered() - $orderItem->getQtyRefunded();
                if (($item->getQty() != $qty) || (!$arguments['adjustment_negative'])) {
                    $product = $modelProduct->load($item->getProductId());
                    $product->setDealQty($product->getDealQty() + $item->getQty())
                        ->setDealBought($product->getDealBought() - $item->getQty())
                        ->save();
                }
            }
        }
    }

    /**
     * Shortcut to getRequest

     */
    protected function _getRequest()
    {
        return Mage::app()->getRequest();
    }

    /** for countdown-mini in category and deals page
     *
     * @param Varien_Event_Observer $observer observed object
     */
    public function coreBlockAbstractToHtmlBefore(Varien_Event_Observer $observer)
    {
        $controller = $this->_getRequest()->getControllerName();
        $module = $this->_getRequest()->getModuleName();
        $showOnSearch = ($controller == 'result') && Mage::helper('dailydeals')->getDealsConfig('deals_category_page/show_on_search');
        if (($controller == 'category') || ($module == 'dailydeals') || $showOnSearch) {
            $block = $observer->getBlock();
            $type = $block->getType();
            if ($type == 'catalog/product_price') {
                if (($block->getProduct()->getDealStatus()) && (Mage::helper('dailydeals')->isDealEnabled($block->getProduct()))) {
                    $block->unsetChild('countdown.mini');
                    $child = clone $block;
                    $child->setType('core/template');
                    $block->setChild('countdown.mini', $child);
                    $block->setTemplate('deals/countdown-mini.phtml');
                }
            }
        }
    }

    public function updateDealsStatuses()
    {
        $helper = Mage::helper('dailydeals');
        $collection = Mage::getResourceModel('catalog/product_collection')
            ->addAttributeToSelect('*')
            ->addAttributeToFilter('deal_status', true);
        foreach ($collection as $item) {
            if ($item->getDealStatus()) {
                $stat = Mage::helper('dailydeals')->checkUpdateDealStatus($item);
                if ($stat != $item->getDealStatuses()) {
                    $helper->changeSpecialData($item, $stat);
                    $item->setDealStatuses($stat)->save();
                }
            }
        }
    }

    /**
     * Cache data after save in category tab
     *
     * @param Varien_Event_Observer $observer observed object
     */
    public function catalogCategoryPrepareSave(Varien_Event_Observer $observer)
    {
        $multiSelectArray = $observer->getCategory()->getDealUpdateDays();
        if (!empty($multiSelectArray)) {
            $multiSelectStr = implode(",", $multiSelectArray);
            $observer->getCategory()->setDealUpdateDays($multiSelectStr)->save();
        }
    }

}