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
$GLOBALS['TL_LANG']['tl_iso_product_collection']['csv_head']['street_2']            = "Zusatz";  
$GLOBALS['TL_LANG']['tl_iso_product_collection']['csv_head']['postal']              = "PLZ";  
$GLOBALS['TL_LANG']['tl_iso_product_collection']['csv_head']['city']                = "Ort";  
$GLOBALS['TL_LANG']['tl_iso_product_collection']['csv_head']['country']             = "Land";  
$GLOBALS['TL_LANG']['tl_iso_product_collection']['csv_head']['phone']               = "Telefon";  
$GLOBALS['TL_LANG']['tl_iso_product_collection']['csv_head']['email']               = "Mailadresse";  
$GLOBALS['TL_LANG']['tl_iso_product_collection']['csv_head']['count']               = "Anzahl";
$GLOBALS['TL_LANG']['tl_iso_product_collection']['csv_head']['items']               = "Artikel";
$GLOBALS['TL_LANG']['tl_iso_product_collection']['csv_head']['item_sku']            = "Artikelnummer";
$GLOBALS['TL_LANG']['tl_iso_product_collection']['csv_head']['item_name']           = "Produktbezeichnung";
$GLOBALS['TL_LANG']['tl_iso_product_collection']['csv_head']['subTotal']            = "Nettopreis";
$GLOBALS['TL_LANG']['tl_iso_product_collection']['csv_head']['tax_free_subtotal']   = "Nettopreis (Steuerfrei)";
$GLOBALS['TL_LANG']['tl_iso_product_collection']['csv_head']['total']               = "Bruttopreis";
$GLOBALS['TL_LANG']['tl_iso_product_collection']['csv_head']['tax_free_total']      = "Bruttopreis (Steuerfrei)";
$GLOBALS['TL_LANG']['tl_iso_product_collection']['csv_head']['tax_label']           = "Steuersatz";
$GLOBALS['TL_LANG']['tl_iso_product_collection']['csv_head']['tax_total_price']     = "Summe Steuern";
$GLOBALS['TL_LANG']['tl_iso_product_collection']['csv_head']['shipping_label']      = "Versandart";
$GLOBALS['TL_LANG']['tl_iso_product_collection']['csv_head']['shipping_total_price']= "Versandkosten";
$GLOBALS['TL_LANG']['tl_iso_product_collection']['csv_head']['shipping_tax_free_total_price']= "Versandkosten (Steuerfrei)";
$GLOBALS['TL_LANG']['tl_iso_product_collection']['csv_head']['sum']                 = "Summe";
$GLOBALS['TL_LANG']['tl_iso_product_collection']['csv_head']['order_status']        = "Bestellstatus";
$GLOBALS['TL_LANG']['tl_iso_product_collection']['csv_head']['billing_address']     = "Rechnungsadresse";
$GLOBALS['TL_LANG']['tl_iso_product_collection']['csv_head']['shipping_address']    = "Lieferadresse";
$GLOBALS['TL_LANG']['tl_iso_product_collection']['csv_head']['item_price']          = "Einzelpreis";
$GLOBALS['TL_LANG']['tl_iso_product_collection']['csv_head']['item_configuration']  = "Konfiguration";
$GLOBALS['TL_LANG']['tl_iso_product_collection']['csv_head']['shipping']            = "Versandart";
$GLOBALS['TL_LANG']['tl_iso_product_collection']['csv_head']['shipping_costs']      = "Versandkosten";
$GLOBALS['TL_LANG']['tl_iso_product_collection']['csv_head']['notes']               = "Notizen";
$GLOBALS['TL_LANG']['tl_iso_product_collection']['csv_head']['affiliateIdentifier'] = "Affiliate Identifier";
$GLOBALS['TL_LANG']['tl_iso_product_collection']['csv_head']['affiliateMember']     = "Affiliate Mitglied";
$GLOBALS['TL_LANG']['tl_iso_product_collection']['csv_head']['affiliateComapny']    = "Affiliate Firma";
$GLOBALS['TL_LANG']['tl_iso_product_collection']['csv_head']['affiliateCity']       = "Affiliate Stadt";

/**
 * Legends
 */
$GLOBALS['TL_LANG']['tl_iso_product_collection']['export_information']  = '
Finanziert durch: <br>
<strong>roschis Medienproduktion</strong>, <a href="https://roschis.net" target="_blank">roschis.net</a>
<br><br>
Entwickelt von: <br>
<strong>inszenium, Inh. Stefan Lehmann</strong>, <a href="https://inszenium.de" target="_blank">inszenium.de</a>'; 

$GLOBALS['TL_LANG']['tl_iso_product_collection']['export_orders_full'] = array
(
  'Vollständiger Export',
  'Exportiert alle Bestellungen und ordnet die Produkte den Kunden zu, inklusive Lieferadresse, Versandkosten und Steuern.'
); 

$GLOBALS['TL_LANG']['tl_iso_product_collection']['export_orders'] = array
(
  'Bestellungen &#8594; Kunde',
  'Exportiert alle Bestellungen und ordnet die Produkte zum KundenIn zu.'
); 

$GLOBALS['TL_LANG']['tl_iso_product_collection']['export_items'] = array
(
  'Produkte &#8594; Kunde',
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

$GLOBALS['TL_LANG']['tl_iso_product_collection']['variant'] = array
(
  'Variante',
  'Bitte wählen sie die Variante aus.'
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