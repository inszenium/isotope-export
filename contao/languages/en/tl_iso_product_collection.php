<?php

declare(strict_types=1);

/*
 * This file is part of Inszenium Isotope eCommerce OrderExport.
 * 
 * (c) inszenium 2025 <https://inszenium.de>
 * @license GPL-3.0-or-later
 * For the full copyright and license information,
 * please view the LICENSE file that was distributed with this source code.
 *
 * @author     Kirsten Roschanski <kirsten.roschanski@inszenium.de>
 * @package    InszeniumIsotopeOrderExport
 * @license    LGPL 
 * @link       https://github.com/inszenium/isotope-export
 */

/**
 * CSV - Data
 */
$GLOBALS['TL_LANG']['tl_iso_product_collection']['csv_head']['order_id']            = "Order ID";  
$GLOBALS['TL_LANG']['tl_iso_product_collection']['csv_head']['date']                = "Order Date";  
$GLOBALS['TL_LANG']['tl_iso_product_collection']['csv_head']['company']             = "Company";
$GLOBALS['TL_LANG']['tl_iso_product_collection']['csv_head']['lastname']            = "Last Name";  
$GLOBALS['TL_LANG']['tl_iso_product_collection']['csv_head']['firstname']           = "First Name";  
$GLOBALS['TL_LANG']['tl_iso_product_collection']['csv_head']['street']              = "Street";  
$GLOBALS['TL_LANG']['tl_iso_product_collection']['csv_head']['street_2']            = "Additional Address";  
$GLOBALS['TL_LANG']['tl_iso_product_collection']['csv_head']['postal']              = "Postal Code";  
$GLOBALS['TL_LANG']['tl_iso_product_collection']['csv_head']['city']                = "City";  
$GLOBALS['TL_LANG']['tl_iso_product_collection']['csv_head']['country']             = "Country";  
$GLOBALS['TL_LANG']['tl_iso_product_collection']['csv_head']['phone']               = "Phone";  
$GLOBALS['TL_LANG']['tl_iso_product_collection']['csv_head']['email']               = "Email Address";  
$GLOBALS['TL_LANG']['tl_iso_product_collection']['csv_head']['count']               = "Quantity";
$GLOBALS['TL_LANG']['tl_iso_product_collection']['csv_head']['items']               = "Items";
$GLOBALS['TL_LANG']['tl_iso_product_collection']['csv_head']['item_sku']            = "Item Number";
$GLOBALS['TL_LANG']['tl_iso_product_collection']['csv_head']['item_name']           = "Product Name";
$GLOBALS['TL_LANG']['tl_iso_product_collection']['csv_head']['subTotal']            = "Net Price";
$GLOBALS['TL_LANG']['tl_iso_product_collection']['csv_head']['tax_free_subtotal']   = "Net Price (Tax-Free)";
$GLOBALS['TL_LANG']['tl_iso_product_collection']['csv_head']['total']               = "Gross Price";
$GLOBALS['TL_LANG']['tl_iso_product_collection']['csv_head']['tax_free_total']      = "Gross Price (Tax-Free)";
$GLOBALS['TL_LANG']['tl_iso_product_collection']['csv_head']['tax_label']           = "Tax Rate";
$GLOBALS['TL_LANG']['tl_iso_product_collection']['csv_head']['tax_total_price']     = "Total Taxes";
$GLOBALS['TL_LANG']['tl_iso_product_collection']['csv_head']['shipping_label']      = "Shipping Method";
$GLOBALS['TL_LANG']['tl_iso_product_collection']['csv_head']['shipping_total_price']= "Shipping Costs";
$GLOBALS['TL_LANG']['tl_iso_product_collection']['csv_head']['shipping_tax_free_total_price']= "Shipping Costs (Tax-Free)";
$GLOBALS['TL_LANG']['tl_iso_product_collection']['csv_head']['sum']                 = "Total";
$GLOBALS['TL_LANG']['tl_iso_product_collection']['csv_head']['order_status']        = "Order Status";
$GLOBALS['TL_LANG']['tl_iso_product_collection']['csv_head']['billing_address']     = "Billing Address";
$GLOBALS['TL_LANG']['tl_iso_product_collection']['csv_head']['shipping_address']    = "Shipping Address";
$GLOBALS['TL_LANG']['tl_iso_product_collection']['csv_head']['item_price']          = "Unit Price";
$GLOBALS['TL_LANG']['tl_iso_product_collection']['csv_head']['item_configuration']  = "Configuration";
$GLOBALS['TL_LANG']['tl_iso_product_collection']['csv_head']['shipping']            = "Shipping Method";
$GLOBALS['TL_LANG']['tl_iso_product_collection']['csv_head']['shipping_costs']      = "Shipping Costs";
$GLOBALS['TL_LANG']['tl_iso_product_collection']['csv_head']['notes']               = "Notes";
$GLOBALS['TL_LANG']['tl_iso_product_collection']['csv_head']['affiliateIdentifier'] = "Affiliate Identifier";
$GLOBALS['TL_LANG']['tl_iso_product_collection']['csv_head']['affiliateMember']     = "Affiliate Member";
$GLOBALS['TL_LANG']['tl_iso_product_collection']['csv_head']['affiliateComapny']    = "Affiliate Company";
$GLOBALS['TL_LANG']['tl_iso_product_collection']['csv_head']['affiliateCity']       = "Affiliate City";

/**
 * Legends
 */
$GLOBALS['TL_LANG']['tl_iso_product_collection']['export_information']  = '
Funded by: <br>
<strong>roschis Medienproduktion</strong>, <a href="https://roschis.net" target="_blank">roschis.net</a>
<br><br>
Developed by: <br>
<strong>inszenium, Inh. Stefan Lehmann</strong>, <a href="https://inszenium.de" target="_blank">inszenium.de</a>'; 

$GLOBALS['TL_LANG']['tl_iso_product_collection']['export_orders_full'] = array
(
  'Full Export',
  'Exports all orders and assigns the products to the customers, including shipping address, shipping costs, and taxes.'
); 

$GLOBALS['TL_LANG']['tl_iso_product_collection']['export_orders'] = array
(
  'Orders &#8594; Customer',
  'Exports all orders and assigns the products to the customer.'
); 

$GLOBALS['TL_LANG']['tl_iso_product_collection']['export_items'] = array
(
  'Products &#8594; Customer',
  'Exports all orders and creates a separate line for each product.'
);  

$GLOBALS['TL_LANG']['tl_iso_product_collection']['export_bank'] = array
(
  'Data for the Bank',
  'All customer data only once.'
);  

$GLOBALS['TL_LANG']['tl_iso_product_collection']['export'] = array
(
  'Export',
  ''
);  

$GLOBALS['TL_LANG']['tl_iso_product_collection']['variant'] = array
(
  'Variant',
  'Please select the variant.'
);

$GLOBALS['TL_LANG']['tl_iso_product_collection']['export_format'] = array
(
  'Export Format',
  'Please select the export format.'
);

$GLOBALS['TL_LANG']['tl_iso_product_collection']['date_from'] = array
(
  'Date From',
  'Please select a date.'
);

$GLOBALS['TL_LANG']['tl_iso_product_collection']['date_to'] = array
(
  'Date To',
  'Please select a date.'
);