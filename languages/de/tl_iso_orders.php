<?php if (!defined('TL_ROOT')) die('You can not access this file directly!');

/**
 * IsotopeOrderExport
 *
 * @copyright  Kirsten Roschanski 2013 <http://kirsten-roschanski.de>
 * @author     Kirsten Roschanski <kat@kirsten-roschanski.de>
 * @package    IsotopeOrderExport
 * @license    LGPL 
 * @link       https://github.com/katgirl/isotope-order_export
 * @filesource
 */

/**
 * CSV - Data
 */
$GLOBALS['TL_LANG']['tl_iso_orders']['csv_head']['order_id']		= "Bestell-ID";	
$GLOBALS['TL_LANG']['tl_iso_orders']['csv_head']['date'	]			  = "Zeitpunkt der Bestellung";	
$GLOBALS['TL_LANG']['tl_iso_orders']['csv_head']['company']			= "Firma";
$GLOBALS['TL_LANG']['tl_iso_orders']['csv_head']['lastname']		= "Name";	
$GLOBALS['TL_LANG']['tl_iso_orders']['csv_head']['firstname']		= "Vorname";	
$GLOBALS['TL_LANG']['tl_iso_orders']['csv_head']['street']			= "Straße";	
$GLOBALS['TL_LANG']['tl_iso_orders']['csv_head']['postal']			= "PLZ";	
$GLOBALS['TL_LANG']['tl_iso_orders']['csv_head']['city']			  = "Ort";	
$GLOBALS['TL_LANG']['tl_iso_orders']['csv_head']['country']			= "Land";	
$GLOBALS['TL_LANG']['tl_iso_orders']['csv_head']['phone']			  = "Telefon";	
$GLOBALS['TL_LANG']['tl_iso_orders']['csv_head']['email']			  = "Mailadresse";	
$GLOBALS['TL_LANG']['tl_iso_orders']['csv_head']['items']			  = "bestellte Produkte mit Preisen";
$GLOBALS['TL_LANG']['tl_iso_orders']['csv_head']['grandTotal']	= "Bruttopreis";
$GLOBALS['TL_LANG']['tl_iso_orders']['csv_head']['count']			  = "Anzahl";
$GLOBALS['TL_LANG']['tl_iso_orders']['csv_head']['item_sku']		= "Artikelnummer";
$GLOBALS['TL_LANG']['tl_iso_orders']['csv_head']['item_name']		= "Produktbezeichnung";
$GLOBALS['TL_LANG']['tl_iso_orders']['csv_head']['subTotal']	  = "Nettopreis";
$GLOBALS['TL_LANG']['tl_iso_orders']['csv_head']['tax']	        = "MwSt.";
$GLOBALS['TL_LANG']['tl_iso_orders']['csv_head']['item_price']	= "Einzelpreis";
$GLOBALS['TL_LANG']['tl_iso_orders']['csv_head']['sum']				  = "Summe";

/**
 * Legends
 */
$GLOBALS['TL_LANG']['tl_iso_orders']['export_orders'] = array
(
	'Exportiere Bestellungen -> Kunde',
	'Exportiert alle Bestellungen und ordnet die Produkte zum KundenIn zu.'
); 
$GLOBALS['TL_LANG']['tl_iso_orders']['export_items'] = array
(
	'Exportiere Produkte -> Kunde',
	'Exportiert alle Bestellungen und legt für jedes Produkte eine seperate Zeile an.'
);  
$GLOBALS['TL_LANG']['tl_iso_orders']['export_bank'] = array
(
	'Exportiere Daten für die Bank',
	''
);  
