<?php
/**
 * Oggetto Web extension for Magento
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade
 * the Oggetto GoogleAnalytics module to newer versions in the future.
 * If you wish to customize the Oggetto GoogleAnalytics module for your needs
 * please refer to http://www.magentocommerce.com for more information.
 *
 * @category   Oggetto
 * @package    Oggetto_GoogleAnalytics
 * @copyright  Copyright (C) 2013 Oggetto Web (http://oggettoweb.com)
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

/**
 * Default helper
 *
 * @category   Oggetto
 * @package    Oggetto_GoogleAnalytics
 * @subpackage Helper
 * @author     Dmitry Buryak <b.dmitry@oggettoweb.com>
 */
class Oggetto_GoogleAnalytics_Helper_Data extends Mage_Core_Helper_Abstract
{
    protected $_categories = array();

    /**
     * Init category collection
     *
     * @param Mage_Sales_Model_Order $order order
     * @return Oggetto_GoogleAnalytics_Helper_Data
     */
    public function initCategoryCollection(Mage_Sales_Model_Order $order)
    {
        $productIds = array();
        foreach ($items = $order->getAllItems() as $item) {
            /* @var $item Mage_Sales_Model_Order_Item */
            $productIds[] = $item->getProductId();

        }
        $collection = Mage::getModel('catalog/product')->getCollection()->addFieldToFilter('entity_id', $productIds);
        foreach ($collection as $product) {
            /* @var $product Mage_Catalog_Model_Product */
            $categories = $product->getCategoryCollection();
            $this->_categories[$product->getId()] = $categories;
        }
        return $this;
    }

    /**
     * Retrieve first loaded category name
     *
     * @param int $productId product identifier
     * @return null|string
     */
    public function getCategoryName($productId)
    {
        if (isset($this->_categories[$productId])) {
            /**
             * @var $categories Mage_Catalog_Model_Resource_Category_Collection
             * @var $category Mage_Catalog_Model_Category
             */
            $categories = $this->_categories[$productId];
            $category = $categories->addAttributeToSelect('name')->getFirstItem();
            return $category->getName();
        }
        return null;
    }
}
