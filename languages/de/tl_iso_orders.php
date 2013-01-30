<?php if (!defined('TL_ROOT')) die('You can not access this file directly!');

/**
 * Contao Open Source CMS
 * Copyright (C) 2005-2013 Leo Feyer
 *
 * Formerly known as TYPOlight Open Source CMS.
 *
 * This program is free software: you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation; either
 * version 3 of the License; or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful;
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU
 * Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public
 * License along with this program. If not; please visit the Free
 * Software Foundation website at <http://www.gnu.org/licenses/>.
 *
 * PHP version 5
 * @copyright  
 * @author     
 * @license    http://opensource.org/licenses/lgpl-3.0.html
 */

/**
 * CSV - Data
 */
$GLOBALS['TL_LANG']['tl_iso_orders']['csv_head']['order_id']		="Bestell-ID";	
$GLOBALS['TL_LANG']['tl_iso_orders']['csv_head']['date'	]			  ="Zeitpunkt der Bestellung";	
$GLOBALS['TL_LANG']['tl_iso_orders']['csv_head']['lastname']		="Name";	
$GLOBALS['TL_LANG']['tl_iso_orders']['csv_head']['firstname']		="Vorname";	
$GLOBALS['TL_LANG']['tl_iso_orders']['csv_head']['street']			="Straße";	
$GLOBALS['TL_LANG']['tl_iso_orders']['csv_head']['postal']			="PLZ";	
$GLOBALS['TL_LANG']['tl_iso_orders']['csv_head']['city']			  ="Ort";	
$GLOBALS['TL_LANG']['tl_iso_orders']['csv_head']['phone']			  ="Telefon";	
$GLOBALS['TL_LANG']['tl_iso_orders']['csv_head']['email']			  ="Mailadresse";	
$GLOBALS['TL_LANG']['tl_iso_orders']['csv_head']['items']			  ="bestellte Produkte mit Preisen";
$GLOBALS['TL_LANG']['tl_iso_orders']['csv_head']['grandTotal']	="Gesamtbestellsumme";
$GLOBALS['TL_LANG']['tl_iso_orders']['csv_head']['count']			  ="Anzahl";
$GLOBALS['TL_LANG']['tl_iso_orders']['csv_head']['item_name']		="Produktbezeichnung";
$GLOBALS['TL_LANG']['tl_iso_orders']['csv_head']['item_price']	="Einzelpreis";
$GLOBALS['TL_LANG']['tl_iso_orders']['csv_head']['sum']				  ="Summe";

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
