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
 * Observer
 *
 * @category   Oggetto
 * @package    Oggetto_GoogleAnalytics
 * @subpackage Model
 * @author     Dmitry Buryak <b.dmitry@oggettoweb.com>
 */
class Oggetto_GoogleAnalytics_Model_Observer
{
    /**
     * Save last category in session
     *
     * @param Varien_Event_Observer $observer observer instance
     * @return Oggetto_GoogleAnalytics_Model_Observer
     */
    public function saveLastCategory(Varien_Event_Observer $observer)
    {
        $session = Mage::getSingleton('customer/session');
        if ($category = Mage::registry('current_category')) {
            $session->setData('last_viewed_category_name', $category->getName());
        } else {
            $session->unsetData('last_viewed_category_name');
        }
        return $this;
    }

    /**
     * Add category name to quote item
     *
     * @param Varien_Event_Observer $observer observer instance
     * @return Oggetto_GoogleAnalytics_Model_Observer
     */
    public function addCategoryNameToQuoteItem(Varien_Event_Observer $observer)
    {
        if ($name = Mage::getSingleton('customer/session')->getData('last_viewed_category_name')) {
            $items = $observer->getEvent()->getData('items');
            foreach ($items as $item) {
                $item->setData('category_name', $name);
            }
        }
        return $this;
    }
}
