<?php

/**
 * Webinse_DailyDeals_Adminhtml_DealsController
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
 * Webinse_DailyDeals_Adminhtml_DealsController.
 *
 * Adminhtml deals controller
 *
 * @category  Webinse
 * @package   Webinse_DailyDeals
 * @author    Webinse Team <info@webinse.com>
 * @copyright 2015 Webinse Ltd. (https://www.webinse.com)
 * @license   The Open Software License 3.0
 * @link      http://opensource.org/licenses/OSL-3.0
 */
class Webinse_DailyDeals_Adminhtml_DealsController extends Mage_Adminhtml_Controller_Action
{

    /**
     * Init actions
     *
     * @return Mage_Adminhtml_Cms_PageController
     */
    protected function _initAction()
    {
        // load layout, set active menu and breadcrumbs
        $this->loadLayout()
            ->_setActiveMenu('webinse')
            ->_title($this->__('Daily Deals'))
            ->_title($this->__('Webinse'));
        $this->_addBreadcrumb(
            Mage::helper('dailydeals')->__('Daily deals'), Mage::helper('dailydeals')->__('Daily deals'), $this->getUrl()
        );

        return $this;
    }

    /**
     * Initialize group
     */
    protected function _initGroup()
    {
        $this->_title($this->__('Product Discount'))->_title($this->__('Manage'));

        Mage::register('current_product', Mage::getModel('catalog/product'));
        $userId = $this->getRequest()->getParam('id');
        if (!is_null($userId)) {
            Mage::registry('current_product')->load($userId);
        }
    }

    /**
     * List action for students grid
     */

    public function listAction()
    {
        $this->_initAction();
        $this->renderLayout();
    }
    /**
     * New action for students grid
     */
    public function newAction()
    {
        $this->_initAction();
        $this->renderLayout();
    }
    /**
     * Edit action for students grid
     */
    public function editAction()
    {
        $this->_initGroup();
        $this->loadLayout();
        $this->_setActiveMenu('webinse/deals');
        $this->_addBreadcrumb(
            Mage::helper('adminhtml')->__('Product Discount'), Mage::helper('adminhtml')->__('Product Discount')
        );
        $this->_addBreadcrumb(
            Mage::helper('adminhtml')->__('Discount'), Mage::helper('adminhtml')->__('Discount'), $this->getUrl('*/discount')
        );

        if ($this->getRequest()->getParam('id')) {
            $this->_addBreadcrumb(
                Mage::helper('adminhtml')->__('Edit Discount'), Mage::helper('adminhtml')->__('Edit Discount')
            );
        } else {
            $this->_addBreadcrumb(
                Mage::helper('adminhtml')->__('New Discount'), Mage::helper('adminhtml')->__('New Discount')
            );
        }
        $this->getLayout()->getBlock('content')
            ->append(
                $this->getLayout()->createBlock('dailydeals/adminhtml_deals_edit', 'discount')
                    ->setEditMode((bool) Mage::registry('current_product')->getId())
            );

        $this->renderLayout();
    }

    /**
     * Deals data filter
     *
     * @param mixed $data Deal data
     *
     * @return array
     */
    protected function filterData($data)
    {
        $data = $this->_filterDates($data, array('deal_start_time', 'deal_end_time'));

        return $data;
    }

    /**
     * Controller for save new deal product
     */
    public function saveAction()
    {

        $id = $this->getRequest()->getParam('id');
        $product = Mage::getModel('catalog/product');
        $data = $this->getRequest()->getParams();
        $data = $this->filterData($data);
        if ($id) {
            try {
                if (!$data['deal_status']) {
                    $data['deal_status'] = true;
                    $data['deal_statuses'] = 'Disabled';
                }
                $product->load($id)->addData($data)->save();
                $this->getResponse()->setRedirect($this->getUrl('*/*/list'));

                return;
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                Mage::getSingleton('adminhtml/session')->setGroupData($product->getData());
                $this->getResponse()->setRedirect($this->getUrl('*/*/edit', array('id' => $id)));

                return;
            }
        } else {
            Mage::getSingleton('adminhtml/session')
                ->addError(Mage::helper('adminhtml')->__('Deal with id \'' . (int) $id . '\' not found.'));
            $this->getResponse()->setRedirect($this->getUrl('*/*/edit', array('id' => $id)));

            return;
        }
    }

    /**
     * Controller for change deal status
     */
    public function massStatusAction()
    {

        $status = $this->getRequest()->getParam('status');
        $ids = $this->getRequest()->getParam('banners');
        if (!$ids) {
            Mage::getSingleton('adminhtml/session')->addError($this->__('Please select Banner(s)'));
        } else {
            try {
                foreach ($ids as $id) {
                    $product = Mage::getModel('catalog/product')
                        ->load($id);
                    if ($status == 0) {
                        $product->setDealStatus(true);
                        $product->setDealStatuses('Disabled');
                    } else {
                        $product->setDealStatus($status);
                        $product->setDealStatuses(null);
                    }

                    $product->save();
                }
                $this->_getSession()->addSuccess(
                    $this->__('Total of %d record(s) were successfully updated', count($ids))
                );
            } catch (Exception $e) {
                $this->_getSession()->addError($e->getMessage());
            }
        }
        $this->_redirect('*/*/list');
    }

    /**
     * for grid ajax
     */
    public function gridAction()
    {
        $this->loadLayout()->renderLayout();
    }

    /**
     * for grid "products" ajax
     */
    public function productsAction()
    {
        $this->loadLayout()->renderLayout();
    }

    /**
     * mass action
     */
    public function massRemoveAction()
    {
        $entityIds = $this->getRequest()->getParam('banners');
        if (!$entityIds) {
            Mage::getSingleton('adminhtml/session')->addError($this->__('Please select Banner(s)'));
        } else {
            try {
                foreach ($entityIds as $entityId) {
                    $product = Mage::getModel('catalog/product')
                        ->load($entityId);
                    Mage::helper('dailydeals')->returnSpecialDataWhenStatusesDisabled($product);
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
                    )->save();
                }
                $this->_getSession()->addSuccess(
                    $this->__('Total of %d record(s) were successfully remove', count($entityIds))
                );
            } catch (Exception $e) {
                $this->_getSession()->addError($e->getMessage());
            }
        }
        $this->_redirect('*/*/list');
    }

    /**
     * for grid ajax
     */
    public function gridcategoryAction()
    {
        $this->loadLayout()->renderLayout();
    }

    /**
     * category action
     */
    public function categoriesAction()
    {
        $this->loadLayout()->renderLayout();
    }

    /**
     * new category
     */
    public function newCategoryAction()
    {
        $this->loadLayout()
            ->_setActiveMenu('webinse')
            ->_title($this->__('Daily Deal Category'))
            ->_title($this->__('Webinse'));
        $this->_addBreadcrumb(
            Mage::helper('dailydeals')->__('Daily Deals Category'), Mage::helper('dailydeals')->__('Daily deals'), $this->getUrl()
        );
        $this->renderLayout();
    }

    /**
     * Grid for category
     */
    public function categoryGridAction()
    {
        Mage::getModel('dailydeals/cron')->updateDealCategory();
        $this->loadLayout()
            ->_setActiveMenu('webinse')
            ->_title($this->__('Daily Deal Category'))
            ->_title($this->__('Webinse'));
        $this->_addBreadcrumb(
            Mage::helper('dailydeals')->__('Daily Deals Category'), Mage::helper('dailydeals')->__('Daily deals'), $this->getUrl()
        );
        $this->renderLayout();
    }

    /**
     * Edit caregory
     */
    public function editCategoryAction()
    {
        $id = $this->getRequest()->getParam('entity_id');
        if (!$id) {
            Mage::getSingleton('adminhtml/session')->addError($this->__('No selected category'));
        } else {
            try {
                Mage::register('current_category', Mage::getModel('catalog/category')->load($id));
                $this->loadLayout()
                    ->_setActiveMenu('webinse')
                    ->_title($this->__('Daily Deal Category'))
                    ->_title($this->__('Webinse'));
                $this->_addBreadcrumb(
                    Mage::helper('dailydeals')->__('Daily Deals Category'), Mage::helper('dailydeals')->__('Daily deals'), $this->getUrl()
                );
                $this->getLayout()->getBlock('content')
                    ->append($this->getLayout()->createBlock('dailydeals/adminhtml_category_edit', 'discount'));
                $this->renderLayout();
            } catch (Exception $e) {
                $this->_getSession()->addError($e->getMessage());
            }
        }
    }

    /**
     * Save deal
     */
    public function saveDealCategoryAction()
    {
        $categoryDealData = array(
            'qty_deal_product' => $this->getRequest()->getParam('qty_deal_product'),
            'deal_update_days' => implode(',', $this->getRequest()->getParam('deal_update_days')),
            'deal_qty_product_percent' => $this->getRequest()->getParam('deal_qty_product_percent'),
            'deal_discount_percent' => $this->getRequest()->getParam('deal_discount_percent')
        );
        $categoryId = $this->getRequest()->getParam('entity_id');
        if ($categoryId && !empty($categoryDealData)) {
            try {
                $categoryModel = Mage::getModel('catalog/category')->load($categoryId);
                $categoryModel->addData($categoryDealData);
                $categoryModel->save();
                $this->_getSession()->addSuccess(
                    $this->__('Category saved')
                );
            } catch (Exception $e) {
                $this->_getSession()->addError($e->getMessage());
            }
        } else {
            Mage::getSingleton('adminhtml/session')->addError($this->__('Please select Category'));
        }
        $this->_redirect('*/*/categoryGrid', array('entity_id' => $categoryId));
    }

    /**
     * Mass Remove Deal Category
     */
    public function massRemoveCatAction()
    {
        $ids = $this->getRequest()->getParam('category_deals_remove');
        if (empty($ids)) {
            Mage::getSingleton('adminhtml/session')->addError($this->__('Please select Category'));
        } else {
            try {
                $catModel = Mage::getModel('catalog/category');
                foreach ($ids as $id) {
                    $this->_removeDealStatusWithCatProduct($id);
                    $catModel->load($id)
                        ->addData(
                            array(
                                'qty_deal_product' => null,
                                'deal_update_days' => null,
                                'deal_qty_product_percent' => null,
                                'deal_discount_percent' => null
                            )
                        )
                        ->save();
                }
                $this->_getSession()->addSuccess(
                    $this->__('Total of %d category(s) were successfully remove', count($ids))
                );
            } catch (Exception $e) {
                $this->_getSession()->addError($e->getMessage());
            }
        }
        $this->_redirect('*/*/categorygrid');
    }

    /**
     * Remove deals status product when remove deal category
     *
     * @param mixed $categoryId id
     */
    protected function _removeDealStatusWithCatProduct($categoryId)
    {
        $productCollection = Mage::getResourceModel('catalog/product_collection')
            ->addAttributeToSelect('*')
            ->addAttributeToFilter('deal_category_id', array("eq" => $categoryId));
        try {
            foreach ($productCollection->getItems() as $item) {
                Mage::helper('dailydeals')->returnSpecialDataWhenStatusesDisabled($item);
                $item->addData(
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
                )
                    ->save();

            }
        } catch (Exception $e) {
            $this->_getSession()->addError($e->getMessage());
        }
    }
}