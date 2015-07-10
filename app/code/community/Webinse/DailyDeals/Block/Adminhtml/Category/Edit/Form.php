<?php
/**
 * Webinse_DailyDeals_Block_Adminhtml_Category_Edit_Form
 *
 * PHP Version 5.5.9
 *
 * @category  Webinse
 * @package   Webinse_DailyDeals
 * @author    Webinse Team <info@webinse.com>
 * @copyright 2015 Webinse Ltd. (https://www.webinse.com)
 * @license   The Open Software License 3.0
 * @link      http://opensource.org/licenses/OSL-3.0
 *
 */
/**
 * Webinse_DailyDeals_Block_Adminhtml_Category_Edit_Form.
 *
 * .
 *
 * @category  Webinse
 * @package   Webinse_DailyDeals
 * @author    Webinse Team <info@webinse.com>
 * @copyright 2015 Webinse Ltd. (https://www.webinse.com)
 * @license   The Open Software License 3.0
 * @link      http://opensource.org/licenses/OSL-3.0
 *
 */
class Webinse_DailyDeals_Block_Adminhtml_Category_Edit_Form extends Mage_Adminhtml_Block_Widget_Form
{
    /**
     * Constructor
     */
    protected function _construct()
    {
        parent::_construct();

    }

    /**
     * Prepare student form
     *
     * @return Mage_Adminhtml_Block_Widget_Form
     */
    protected function _prepareForm()
    {
        $data = Mage::registry('current_category');
        $helper = Mage::helper('dailydeals');
        $form = new Varien_Data_Form(
            array(
            'id' => 'edit_form',
            'action' => $this->getUrl('*/*/savedealcategory', array('id' => $this->getRequest()->getParam('id'))),
            'method' => 'post',
        )
        );


        $fieldset = $form->addFieldset(
            'deals_form', array(
            'legend' => $helper->__('Category Information')
        )
        );

        if (!is_null($data->getId())) {
            // If edit add id
            $form->addField(
                'entity_id', 'hidden', array(
                    'name' => 'entity_id',
                    'value' => $data->getId())
            );
        }

        $fieldset->addField(
            'name', 'label', array(
            'label' => $helper->__('Category Name'),
            'class' => 'required-entry',
            'name' => 'name'
        )
        );

        $fieldset->addField(
            'qty_deal_product', 'text', array(
            'label' => $helper->__('Qty Deal Products'),
            'class' => 'required-entry',
            'name' => 'qty_deal_product',
            'required' => true,
            'note' => $helper->__('Quantity products with special price in category'),
        )
        );
        $fieldset->addField(
            'deal_update_days', 'multiselect', array(
            'label' => $helper->__('Deal Products will be run and update each'),
            'name' => 'deal_update_days',
            'note' => $helper->__('Selected Deals Days'),
            'required' => true,
            'values' => Mage::getModel('dailydeals/entity_attribute_source_days')->getAllOptions()
        )
        );
        $fieldset->addField(
            'deal_qty_product_percent', 'text', array(
            'label' => $helper->__('Qty Deal Product (depends on availability in stock)'),
            'name' => 'deal_qty_product_percent',
            'required' => true,
        )
        );
        $fieldset->addField(
            'deal_discount_percent', 'text', array(
            'label' => $helper->__('Deal Discount Percent'),
            'name' => 'deal_discount_percent',
            'note' => $helper->__('Enter Discount Percent'),
            'required' => true,
        )
        );


        $form->setValues($data);

        $form->setUseContainer(true);
        $form->setId('edit_form');
        $this->setForm($form);
    }
}