<?php

/**
 * IsotopeOrderExport
 *
 * @copyright  inszenium 2016 <https://inszenium.de>
 * @author     Kirsten Roschanski <kirsten.roschanski@inszenium.de>
 * @package    IsotopeOrderExport
 * @license    LGPL 
 * @link       https://github.com/inszenium/isotope-export
 * @filesource
 */

/**
 * CSV - Data
 */
$GLOBALS['TL_LANG']['tl_iso_product_collection']['csv_head']['order_id']            = "Bestell-ID";  
$GLOBALS['TL_LANG']['tl_iso_product_collection']['csv_head']['date'  ]              = "Zeitpunkt der Bestellung";  
$GLOBALS['TL_LANG']['tl_iso_product_collection']['csv_head']['company']             = "Firma";
$GLOBALS['TL_LANG']['tl_iso_product_collection']['csv_head']['lastname']            = "Name";  
$GLOBALS['TL_LANG']['tl_iso_product_collection']['csv_head']['firstname']           = "Vorname";  
$GLOBALS['TL_LANG']['tl_iso_product_collection']['csv_head']['street']              = "Straße";  
$GLOBALS['TL_LANG']['tl_iso_product_collection']['csv_head']['postal']              = "PLZ";  
$GLOBALS['TL_LANG']['tl_iso_product_collection']['csv_head']['city']                = "Ort";  
$GLOBALS['TL_LANG']['tl_iso_product_collection']['csv_head']['country']             = "Land";  
$GLOBALS['TL_LANG']['tl_iso_product_collection']['csv_head']['phone']               = "Telefon";  
$GLOBALS['TL_LANG']['tl_iso_product_collection']['csv_head']['email']               = "Mailadresse";  
$GLOBALS['TL_LANG']['tl_iso_product_collection']['csv_head']['items']               = "bestellte Produkte mit Preisen";
$GLOBALS['TL_LANG']['tl_iso_product_collection']['csv_head']['grandTotal']          = "Bruttopreis";
$GLOBALS['TL_LANG']['tl_iso_product_collection']['csv_head']['count']               = "Anzahl";
$GLOBALS['TL_LANG']['tl_iso_product_collection']['csv_head']['item_sku']            = "Artikelnummer";
$GLOBALS['TL_LANG']['tl_iso_product_collection']['csv_head']['item_name']           = "Produktbezeichnung";
$GLOBALS['TL_LANG']['tl_iso_product_collection']['csv_head']['subTotal']            = "Nettopreis";
$GLOBALS['TL_LANG']['tl_iso_product_collection']['csv_head']['tax']                 = "MwSt.";
$GLOBALS['TL_LANG']['tl_iso_product_collection']['csv_head']['item_price']          = "Einzelpreis";
$GLOBALS['TL_LANG']['tl_iso_product_collection']['csv_head']['item_configuration']  = "Konfiguration";
$GLOBALS['TL_LANG']['tl_iso_product_collection']['csv_head']['sum']                 = "Summe";

/**
 * Legends
 */
$GLOBALS['TL_LANG']['tl_iso_product_collection']['export_information']  = array
(
  'Finanziert durch: <br><strong>International Drums&Percussion Camp Weinfelden</strong><br><br>Entwickelt von: <br><strong>inszenium Plauen</strong>',
  ''
); 
 
$GLOBALS['TL_LANG']['tl_iso_product_collection']['export_orders'] = array
(
  'Bestellungen -> Kunde (UTF-8)',
  'Exportiert alle Bestellungen und ordnet die Produkte zum KundenIn zu.'
); 
$GLOBALS['TL_LANG']['tl_iso_product_collection']['export_items'] = array
(
  'Produkte -> Kunde (UTF-8)',
  'Exportiert alle Bestellungen und legt für jedes Produkte eine seperate Zeile an.'
);  
$GLOBALS['TL_LANG']['tl_iso_product_collection']['export_bank'] = array
(
  'Daten für die Bank (UTF-8)',
  'Alle Kundendaten nur einmal.'
);  

$GLOBALS['TL_LANG']['tl_iso_product_collection']['export_excel_orders'] = array
(
  'Bestellungen -> Kunde (WIN)',
  'Exportiert alle Bestellungen und ordnet die Produkte zum KundenIn zu.'
); 
$GLOBALS['TL_LANG']['tl_iso_product_collection']['export_excel_items'] = array
(
  'Produkte -> Kunde (WIN)',
  'Exportiert alle Bestellungen und legt für jedes Produkte eine seperate Zeile an.'
);  
$GLOBALS['TL_LANG']['tl_iso_product_collection']['export_excel_bank'] = array
(
  'Daten für die Bank (WIN)',
  'Alle Kundendaten nur einmal.'
);

$GLOBALS['TL_LANG']['tl_iso_product_collection']['export'] = array
(
  'Exportieren',
  ''
);  
