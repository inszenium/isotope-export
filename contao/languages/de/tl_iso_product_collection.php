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
$GLOBALS['TL_LANG']['tl_iso_product_collection']['csv_head']['total']               = "Bruttopreis";
$GLOBALS['TL_LANG']['tl_iso_product_collection']['csv_head']['count']               = "Anzahl";
$GLOBALS['TL_LANG']['tl_iso_product_collection']['csv_head']['item_sku']            = "Artikelnummer";
$GLOBALS['TL_LANG']['tl_iso_product_collection']['csv_head']['item_name']           = "Produktbezeichnung";
$GLOBALS['TL_LANG']['tl_iso_product_collection']['csv_head']['tax_free_subtotal']   = "Nettopreis";
$GLOBALS['TL_LANG']['tl_iso_product_collection']['csv_head']['subTotal']            = "Nettopreis";
$GLOBALS['TL_LANG']['tl_iso_product_collection']['csv_head']['tax']                 = "MwSt.";
$GLOBALS['TL_LANG']['tl_iso_product_collection']['csv_head']['item_price']          = "Einzelpreis";
$GLOBALS['TL_LANG']['tl_iso_product_collection']['csv_head']['item_configuration']  = "Konfiguration";
$GLOBALS['TL_LANG']['tl_iso_product_collection']['csv_head']['sum']                 = "Summe";

/**
 * Legends
 */
$GLOBALS['TL_LANG']['tl_iso_product_collection']['export_information']  = '
Finanziert durch: <br>
<strong>roschis Medienproduktion</strong>, <a href="https://roschis.net" target="_blank">roschis.net</a>
<br><br>
Entwickelt von: <br>
<strong>inszenium, Inh. Stefan Lehmann</strong>, <a href="https://inszenium.de" target="_blank">inszenium.de</a>'; 
 
$GLOBALS['TL_LANG']['tl_iso_product_collection']['export_orders'] = array
(
  'Bestellungen -> Kunde',
  'Exportiert alle Bestellungen und ordnet die Produkte zum KundenIn zu.'
); 
$GLOBALS['TL_LANG']['tl_iso_product_collection']['export_items'] = array
(
  'Produkte -> Kunde',
  'Exportiert alle Bestellungen und legt für jedes Produkte eine seperate Zeile an.'
);  
$GLOBALS['TL_LANG']['tl_iso_product_collection']['export_bank'] = array
(
  'Daten für die Bank',
  'Alle Kundendaten nur einmal.'
);  

$GLOBALS['TL_LANG']['tl_iso_product_collection']['export'] = array
(
  'Exportieren',
  ''
);  

$GLOBALS['TL_LANG']['tl_iso_product_collection']['export_format'] = array
(
  'Exportformat',
  'Bitte wählen sie das Exportformat aus.'
);

$GLOBALS['TL_LANG']['tl_iso_product_collection']['date_from'] = array
(
  'Datum von',
  'Bitte wählen sie ein Datum aus.'
);

$GLOBALS['TL_LANG']['tl_iso_product_collection']['date_to'] = array
(
  'Datum bis',
  'Bitte wählen sie ein Datum aus.'
);