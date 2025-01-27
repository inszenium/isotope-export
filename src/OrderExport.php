<?php

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

namespace Inszenium\IsotopeExport;

use Contao\Backend;
use Contao\Input;
use Contao\FileUpload;
use Contao\Message;
use Contao\System;
use Contao\Config;
use Contao\Environment;
use Contao\StringUtil;
use Contao\Validator;
use Contao\Database;
use Contao\Exception;
use Isotope\Isotope;
use Isotope\Interfaces\IsotopeProduct;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Csv;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Writer\Ods;

/**
 * Class OrderExport
 * Provide miscellaneous methods that are used by the data configuration array.
 */
class OrderExport extends Backend
{
  /**
   * Import an Isotope object
   */
  public function __construct()
  {
    parent::__construct();
    \System::loadLanguageFile('countries');
  }
  
  /**
	 * Return a form to choose a CSV/XLS file and export it
	 *
	 * @return string
	 */
	public function exportOrders()
	{
		if (Input::get('key') != 'export')
		{
			return '';
		}

    // Überprüfe, ob das Formular abgeschickt wurde
    if (Input::post('FORM_SUBMIT') === 'iso_export_orders') {
      $dateFrom = Input::post('date_from') ? Input::post('date_from') : '2000-01-01';
      $dateTo = Input::post('date_to') ? Input::post('date_to') : date('Y-m-d');
      $format = Input::post('format');
      $separator = Input::post('separator');
      $variant = Input::post('variant');

      // Export je nach Variante ausführen
      switch ($variant) {
          case 'export_orders':
              $this->exportOrdersData($dateFrom, $dateTo, $format, $separator);
              break;
          case 'export_items':
              $this->exportItemsData($dateFrom, $dateTo, $format, $separator);
              break;
          case 'export_bank':
              $this->exportBankData($dateFrom, $dateTo, $format, $separator);
              break;
          case 'export_orders_full':
              $this->exportFullOrdersData($dateFrom, $dateTo, $format, $separator);
              break;
          default:
              throw new Exception('Unsupported variant: ' . $variant);    
      }
    }

		// Return form
		return '
<div id="tl_buttons">
<a href="' . StringUtil::ampersand(str_replace('&key=export', '', Environment::get('requestUri'))) . '" class="header_back" title="' . StringUtil::specialchars($GLOBALS['TL_LANG']['MSC']['backBTTitle']) . '" accesskey="b">' . $GLOBALS['TL_LANG']['MSC']['backBT'] . '</a>
</div>
' . Message::generate() . '
<form id="iso_export_orders" class="tl_form tl_edit_form" method="post" enctype="multipart/form-data">
<div class="tl_formbody_edit">
<input type="hidden" name="FORM_SUBMIT" value="iso_export_orders">
<input type="hidden" name="REQUEST_TOKEN" value="' . htmlspecialchars(System::getContainer()->get('contao.csrf.token_manager')->getDefaultTokenValue(), ENT_QUOTES | ENT_SUBSTITUTE | ENT_HTML5) . '">

<div id="tl_breadcrumb" style="width: 90%; margin: 20px auto;">' . $GLOBALS['TL_LANG']['tl_iso_product_collection']['export_information'] . '</div>

<fieldset class="tl_tbox nolegend">
  <div class="widget w50">
    <h3><label for="date_from">' . $GLOBALS['TL_LANG']['tl_iso_product_collection']['date_from'][0] . '</label></h3>
    <input type="date" name="date_from" id="date_from" class="tl_text">
    <p class="tl_help tl_tip">' . $GLOBALS['TL_LANG']['tl_iso_product_collection']['date_from'][1] . '</p>
  </div>
  <div class="widget w50">
    <h3><label for="date_to">' . $GLOBALS['TL_LANG']['tl_iso_product_collection']['date_to'][0] . '</label></h3>
    <input type="date" name="date_to" id="date_to" class="tl_text">
    <p class="tl_help tl_tip">' . $GLOBALS['TL_LANG']['tl_iso_product_collection']['date_to'][1] . '</p>
  </div>
  <div class="widget w50">
    <h3><label for="format">' . $GLOBALS['TL_LANG']['tl_iso_product_collection']['export_format'][0] . '</label></h3>
    <select name="format" id="format" class="tl_select" onchange="toggleSeparator(this.value)">
      <option value="xlsx">Office Open XML (.xlsx) Excel 2007 and above</option>
      <option value="ods">Open Document Format/OASIS (.ods)</option>
      <option value="csv">CSV</option>
    </select>
    <p class="tl_help tl_tip">' . $GLOBALS['TL_LANG']['tl_iso_product_collection']['export_format'][1] . '</p>
  </div>
  <div class="widget w50" id="separator-container" style="display:none;">
    <h3><label for="separator">' . $GLOBALS['TL_LANG']['MSC']['separator'][0] . '</label></h3>
    <select name="separator" id="separator" class="tl_select" data-action="focus->contao--scroll-offset#store">
      <option value="comma">' . $GLOBALS['TL_LANG']['MSC']['comma'] . '</option>
      <option value="semicolon">' . $GLOBALS['TL_LANG']['MSC']['semicolon'] . '</option>
      <option value="tabulator">' . $GLOBALS['TL_LANG']['MSC']['tabulator'] . '</option>
      <option value="linebreak">' . $GLOBALS['TL_LANG']['MSC']['linebreak'] . '</option>
    </select>' . ($GLOBALS['TL_LANG']['MSC']['separator'][1] ? '
    <p class="tl_help tl_tip">' . $GLOBALS['TL_LANG']['MSC']['separator'][1] . '</p>' : '') . '
  </div>
  <div class="widget w50">
    <h3><label for="variant">' . $GLOBALS['TL_LANG']['tl_iso_product_collection']['variant'][0] . '</label></h3>
    <select name="variant" id="variant" class="tl_select">
      <option value="export_orders_full">' . $GLOBALS['TL_LANG']['tl_iso_product_collection']['export_orders_full'][0] . ' (' . $GLOBALS['TL_LANG']['tl_iso_product_collection']['export_orders_full'][1] . ')</option>
      <option value="export_orders">' . $GLOBALS['TL_LANG']['tl_iso_product_collection']['export_orders'][0] . ' (' . $GLOBALS['TL_LANG']['tl_iso_product_collection']['export_orders'][1] . ')</option>
      <option value="export_items">' . $GLOBALS['TL_LANG']['tl_iso_product_collection']['export_items'][0] . ' (' . $GLOBALS['TL_LANG']['tl_iso_product_collection']['export_items'][1] . ')</option>
      <option value="export_bank">' . $GLOBALS['TL_LANG']['tl_iso_product_collection']['export_bank'][0] . ' (' . $GLOBALS['TL_LANG']['tl_iso_product_collection']['export_bank'][1] . ')</option>
    </select>
    <p class="tl_help tl_tip">' . $GLOBALS['TL_LANG']['tl_iso_product_collection']['variant'][1] . '</p>
  </div>
</fieldset>

</div>

<div class="tl_formbody_submit">

<div class="tl_submit_container">
  <button type="submit" name="save" id="save" class="tl_submit" accesskey="s">' . $GLOBALS['TL_LANG']['tl_iso_product_collection']['export'][0] . '</button>
</div>

</div>
</form>
<script>
function toggleSeparator(format) {
  var separatorContainer = document.getElementById("separator-container");
  if (format === "csv") {
    separatorContainer.style.display = "block";
  } else {
    separatorContainer.style.display = "none";
  }
}
</script>';
	}

  /**
   * Export orders and send them to browser as file
   * @param date $dateFrom
   * @param date $dateTo
   * @param string $format
   * @param string $separator
   */
  public function exportFullOrdersData($dateFrom, $dateTo, $format, $separator)
  {    
    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();
    $arrKeys = array('order_id', 'order_status', 'date', 'billing_address', 'company', 'lastname', 'firstname', 'street', 'street_2', 'postal', 'city', 'country', 'phone', 'email', 
                                                         'shipping_address', 'company', 'lastname', 'firstname', 'street', 'street_2', 'postal', 'city', 'country', 'phone', 'email', 
                     'subTotal', 'tax_free_subtotal', 'total', 'tax_free_total', 'tax_label', 'tax_total_price', 'shipping_label', 'shipping_total_price', 'shipping_tax_free_total_price', 'items', 'notes');

    if (class_exists('Veello\IsotopeAffiliatesBundle\VeelloIsotopeAffiliatesBundle')) {
      $arrKeys[] = 'affiliateIdentifier';
      $arrKeys[] = 'affiliateComapny';
      $arrKeys[] = 'affiliateCity';
    }

    foreach ($arrKeys as $k => $v) {
      

      if($k > 25 && $k < 48) {
        $sheet->setCellValue('A' . chr(65 + $k%26) . '1', $GLOBALS['TL_LANG']['tl_iso_product_collection']['csv_head'][$v]);
      } else {
        $sheet->setCellValue(chr(65 + $k) . '1', $GLOBALS['TL_LANG']['tl_iso_product_collection']['csv_head'][$v]);
      }
    }

    $objOrders = \Database::getInstance()->prepare("SELECT tl_iso_product_collection.*, tl_iso_product_collection.id as collection_id, tl_iso_orderstatus.name as order_status 
                                                    FROM tl_iso_product_collection, tl_iso_orderstatus
                                                    WHERE type = 'order'
                                                      AND document_number != '' 
                                                      AND locked >= ? 
                                                      AND locked <= ?
                                                      AND tl_iso_product_collection.order_status = tl_iso_orderstatus.id
                                                    ORDER BY document_number ASC")
                                         ->execute(strtotime($dateFrom . " 00:00:00"), strtotime($dateTo . " 23:59:59"));

    if ($objOrders->numRows < 1) {
      return '<p class="tl_error">'. $GLOBALS['TL_LANG']['MSC']['noOrders'] .'</p>';
    }

    $row = 2;
    while ($objOrders->next()) {
      $objOrderItems = \Database::getInstance()->query("SELECT sku, name, price, quantity FROM tl_iso_product_collection_item WHERE pid = " . $objOrders->collection_id);
      $objBillingAddress = \Database::getInstance()->query("SELECT * FROM tl_iso_address WHERE id = " . $objOrders->billing_address_id);
      $objShippingAddress = \Database::getInstance()->query("SELECT * FROM tl_iso_address WHERE id = " . $objOrders->shipping_address_id);
      $objTax = \Database::getInstance()->query("SELECT label, total_price FROM tl_iso_product_collection_surcharge WHERE pid = " . $objOrders->collection_id . " AND type = 'tax'");
      $objShipping = \Database::getInstance()->query("SELECT label, total_price, tax_free_total_price FROM tl_iso_product_collection_surcharge WHERE pid = " . $objOrders->collection_id . " AND type = 'shipping'");
      $objAffiliateMember = \Database::getInstance()->query("SELECT company, city  FROM tl_member WHERE id = " . $objOrders->affiliateMember);
      
      
      $strOrderItems = '';

      if($objOrderItems->numRows < 1) {
        continue;
      }

      while ($objOrderItems->next()) {
        // wenn schon ein Produkt da ist, dann einen Zeilenumbruch machen für Excel
        if (strlen($strOrderItems) > 0) {
          $strOrderItems .= PHP_EOL;
        }  
  
        $strOrderItems .= html_entity_decode(
        $objOrderItems->quantity . " x " . strip_tags($objOrderItems->name) . " [" . $objOrderItems->sku . "] " .
        " á " . strip_tags(Isotope::formatPriceWithCurrency($objOrderItems->price)) .
        " (" . strip_tags(Isotope::formatPriceWithCurrency($objOrderItems->quantity * $objOrderItems->price)) . ")"
        );
      }

      $sheet->setCellValue('A' . $row, $objOrders->document_number);
      $sheet->setCellValue('B' . $row, $objOrders->order_status);
      $sheet->setCellValue('C' . $row, $this->parseDate(Config::get('datimFormat'), $objOrders->locked));
      $sheet->setCellValue('D' . $row, $objBillingAddress->company . PHP_EOL . $objBillingAddress->firstname . ' ' . $objBillingAddress->lastname . PHP_EOL . $objBillingAddress->street_1 . PHP_EOL . $objBillingAddress->street_2 . PHP_EOL . $objBillingAddress->postal . ' ' . $objBillingAddress->city . PHP_EOL . $GLOBALS['TL_LANG']['CNT'][$objBillingAddress->country] . PHP_EOL . PHP_EOL . $objBillingAddress->phone . PHP_EOL . $objBillingAddress->email);
      $sheet->setCellValue('E' . $row, $objBillingAddress->company);
      $sheet->setCellValue('F' . $row, $objBillingAddress->lastname);
      $sheet->setCellValue('G' . $row, $objBillingAddress->firstname);
      $sheet->setCellValue('H' . $row, $objBillingAddress->street_1);
      $sheet->setCellValue('I' . $row, $objBillingAddress->street_2);
      $sheet->setCellValue('J' . $row, $objBillingAddress->postal);
      $sheet->setCellValue('K' . $row, $objBillingAddress->city);
      $sheet->setCellValue('L' . $row, $GLOBALS['TL_LANG']['CNT'][$objBillingAddress->country]);
      $sheet->setCellValue('M' . $row, $objBillingAddress->phone);
      $sheet->setCellValue('N' . $row, $objBillingAddress->email);
      $sheet->setCellValue('O' . $row, $objShippingAddress->company . PHP_EOL . $objShippingAddress->firstname . ' ' . $objShippingAddress->lastname . PHP_EOL . $objShippingAddress->street_1 . PHP_EOL . $objShippingAddress->street_2 . PHP_EOL . $objShippingAddress->postal . ' ' . $objShippingAddress->city . PHP_EOL . $GLOBALS['TL_LANG']['CNT'][$objShippingAddress->country] . PHP_EOL . PHP_EOL . $objShippingAddress->phone . PHP_EOL . $objShippingAddress->email);
      $sheet->setCellValue('P' . $row, $objShippingAddress->company);
      $sheet->setCellValue('Q' . $row, $objShippingAddress->lastname);
      $sheet->setCellValue('R' . $row, $objShippingAddress->firstname);
      $sheet->setCellValue('S' . $row, $objShippingAddress->street_1);
      $sheet->setCellValue('T' . $row, $objShippingAddress->street_2);
      $sheet->setCellValue('U' . $row, $objShippingAddress->postal);
      $sheet->setCellValue('V' . $row, $objShippingAddress->city);
      $sheet->setCellValue('W' . $row, $GLOBALS['TL_LANG']['CNT'][$objShippingAddress->country]);
      $sheet->setCellValue('X' . $row, $objShippingAddress->phone);
      $sheet->setCellValue('Y' . $row, $objShippingAddress->email);
      $sheet->setCellValue('Z' . $row, strip_tags(html_entity_decode(Isotope::formatPriceWithCurrency($objOrders->subTotal))));
      $sheet->setCellValue('AA' . $row, strip_tags(html_entity_decode(Isotope::formatPriceWithCurrency($objOrders->tax_free_subtotal))));
      $sheet->setCellValue('AB' . $row, strip_tags(html_entity_decode(Isotope::formatPriceWithCurrency($objOrders->total))));
      $sheet->setCellValue('AC' . $row, strip_tags(html_entity_decode(Isotope::formatPriceWithCurrency($objOrders->tax_free_total))));
      $sheet->setCellValue('AD' . $row, $objTax->label);
      $sheet->setCellValue('AE' . $row, strip_tags(html_entity_decode(Isotope::formatPriceWithCurrency($objTax->total_price))));
      $sheet->setCellValue('AF' . $row, $objShipping->label);
      $sheet->setCellValue('AG' . $row, strip_tags(html_entity_decode(Isotope::formatPriceWithCurrency($objShipping->total_price))));
      $sheet->setCellValue('AH' . $row, strip_tags(html_entity_decode(Isotope::formatPriceWithCurrency($objShipping->tax_free_total_price))));
      $sheet->setCellValue('AI' . $row, $strOrderItems);
      $sheet->setCellValue('AJ' . $row, $objOrders->notes);
      $sheet->setCellValue('AK' . $row, $objOrders->affiliateIdentifier);
      $sheet->setCellValue('AL' . $row, $objAffiliateMember->company);
      $sheet->setCellValue('AM' . $row, $objAffiliateMember->city);
      $row++;
    }
    
    // Output
    $this->saveToBrowser($spreadsheet, $format, $separator);
  }

  /**
   * Export orders and send them to browser as file
   * @param date $dateFrom
   * @param date $dateTo
   * @param string $format
   * @param string $separator
   */
  public function exportOrdersData($dateFrom, $dateTo, $format, $separator)
  {    
    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();
    $arrKeys = array('order_id', 'date', 'company', 'lastname', 'firstname', 'street', 'postal', 'city', 'country', 'phone', 'email', 'items', 'tax_free_subtotal', 'total');
    
    foreach ($arrKeys as $k => $v) {
      $sheet->setCellValue(chr(65 + $k) . '1', $GLOBALS['TL_LANG']['tl_iso_product_collection']['csv_head'][$v]);
    }

    $objOrders = \Database::getInstance()->prepare("SELECT *, tl_iso_product_collection.id as collection_id 
                                                    FROM tl_iso_product_collection, tl_iso_address 
                                                    WHERE tl_iso_product_collection.billing_address_id = tl_iso_address.id 
                                                      AND type = 'order'
                                                      AND locked >= ? 
                                                      AND locked <= ?
                                                    ORDER BY document_number ASC")
                                         ->execute(strtotime($dateFrom . " 00:00:00"), strtotime($dateTo . " 23:59:59"));

    if ($objOrders->numRows < 1) {
      return '<p class="tl_error">'. $GLOBALS['TL_LANG']['MSC']['noOrders'] .'</p>';
    }

    $row = 2;
    while ($objOrders->next()) {
      $objOrderItems = \Database::getInstance()->query("SELECT sku, name, price, quantity FROM tl_iso_product_collection_item WHERE pid = " . $objOrders->collection_id);
      $strOrderItems = '';

      if($objOrderItems->numRows < 1) {
        continue;
      }

      while ($objOrderItems->next()) {
        // wenn schon ein Produkt da ist, dann einen Zeilenumbruch machen für Excel
        if (strlen($strOrderItems) > 0) {
          $strOrderItems .= PHP_EOL;
        }  
  
        $strOrderItems .= html_entity_decode(
        $objOrderItems->quantity . " x " . strip_tags($objOrderItems->name) . " [" . $objOrderItems->sku . "] " .
        " á " . strip_tags(Isotope::formatPriceWithCurrency($objOrderItems->price)) .
        " (" . strip_tags(Isotope::formatPriceWithCurrency($objOrderItems->quantity * $objOrderItems->price)) . ")"
        );
      }

      $sheet->setCellValue('A' . $row, $objOrders->document_number);
      $sheet->setCellValue('B' . $row, $this->parseDate(Config::get('datimFormat'), $objOrders->locked));
      $sheet->setCellValue('C' . $row, $objOrders->company);
      $sheet->setCellValue('D' . $row, $objOrders->lastname);
      $sheet->setCellValue('E' . $row, $objOrders->firstname);
      $sheet->setCellValue('F' . $row, $objOrders->street_1);
      $sheet->setCellValue('G' . $row, $objOrders->postal);
      $sheet->setCellValue('H' . $row, $objOrders->city);
      $sheet->setCellValue('I' . $row, $GLOBALS['TL_LANG']['CNT'][$objOrders->country]);
      $sheet->setCellValue('J' . $row, $objOrders->phone);
      $sheet->setCellValue('K' . $row, $objOrders->email);
      $sheet->setCellValue('L' . $row, $strOrderItems);
      $sheet->setCellValue('M' . $row, strip_tags(html_entity_decode(Isotope::formatPriceWithCurrency($objOrders->tax_free_subtotal))));
      $sheet->setCellValue('N' . $row, strip_tags(html_entity_decode(Isotope::formatPriceWithCurrency($objOrders->total))));
      $row++;
    }
    
    // Output
    $this->saveToBrowser($spreadsheet, $format, $separator);
  }
  
  /**
   * Export orders and send them to browser as file
   * @param date $dateFrom
   * @param date $dateTo
   * @param string $format
   * @param string $separator
   */
  public function exportItemsData($dateFrom, $dateTo, $format, $separator)
  {    
    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();
    $arrKeys = array('order_id', 'date', 'company', 'lastname', 'firstname', 'street', 'postal', 'city', 'country', 'phone', 'email', 'count', 'item_sku', 'item_name', 'item_configuration', 'item_price', 'sum');
   
    foreach ($arrKeys as $k => $v) {
      $sheet->setCellValue(chr(65 + $k) . '1', $GLOBALS['TL_LANG']['tl_iso_product_collection']['csv_head'][$v]);
    }

    $objOrders = \Database::getInstance()->prepare("SELECT *, tl_iso_product_collection.id as collection_id 
                                                    FROM tl_iso_product_collection_item, tl_iso_product_collection, tl_iso_address 
                                                    WHERE tl_iso_product_collection_item.pid = tl_iso_product_collection.id 
                                                      AND tl_iso_product_collection.billing_address_id = tl_iso_address.id 
                                                      AND type = 'order'
                                                      AND locked >= ? 
                                                      AND locked <= ?
                                                    ORDER BY document_number ASC")
                                         ->execute(strtotime($dateFrom . " 00:00:00"), strtotime($dateTo . " 23:59:59")); 

    if ($objOrders->numRows < 1) {
      return '<p class="tl_error">'. $GLOBALS['TL_LANG']['MSC']['noOrders'] .'</p>';
    }

    $row = 2;
    while ($objOrders->next()) {
      $arrConfig = deserialize($objOrders->configuration);
      $strConfig = '';
      if (is_array($arrConfig)) {
        foreach ($arrConfig as $key => $value) {
          if (strlen($strConfig) > 1) {
            $strConfig .= PHP_EOL;
          }
          $arrValues = deserialize($value);
          $strConfig .= \Isotope\Translation::get($key) . ": " . (is_array($arrValues) ? implode(",", $arrValues) : \Isotope\Translation::get($value));
        }
      }

      $sheet->setCellValue('A' . $row, $objOrders->document_number);
      $sheet->setCellValue('B' . $row, $this->parseDate($GLOBALS['TL_CONFIG']['datimFormat'], $objOrders->locked));
      $sheet->setCellValue('C' . $row, $objOrders->company);
      $sheet->setCellValue('D' . $row, $objOrders->lastname);
      $sheet->setCellValue('E' . $row, $objOrders->firstname);
      $sheet->setCellValue('F' . $row, $objOrders->street_1);
      $sheet->setCellValue('G' . $row, $objOrders->postal);
      $sheet->setCellValue('H' . $row, $objOrders->city);
      $sheet->setCellValue('I' . $row, $GLOBALS['TL_LANG']['CNT'][$objOrders->country]);
      $sheet->setCellValue('J' . $row, $objOrders->phone);
      $sheet->setCellValue('K' . $row, $objOrders->email);
      $sheet->setCellValue('L' . $row, $objOrders->quantity);
      $sheet->setCellValue('M' . $row, html_entity_decode($objOrders->sku));
      $sheet->setCellValue('N' . $row, strip_tags(html_entity_decode($objOrders->name)));
      $sheet->setCellValue('O' . $row, strip_tags(html_entity_decode($strConfig)));
      $sheet->setCellValue('P' . $row, strip_tags(html_entity_decode(Isotope::formatPriceWithCurrency($objOrders->price))));
      $sheet->setCellValue('Q' . $row, strip_tags(html_entity_decode(Isotope::formatPriceWithCurrency($objOrders->quantity * $objOrders->price))));
      $row++;
    }
  
    // Output
    $this->saveToBrowser($spreadsheet, $format, $separator);
  }  
  
  /**
   * Export orders and send them to browser as file
   * @param date $dateFrom
   * @param date $dateTo
   * @param string $format
   * @param string $separator
   */
  public function exportBankData($dateFrom, $dateTo, $format, $separator)
  {     
    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();
    $arrKeys = array('company', 'lastname', 'firstname', 'street', 'postal', 'city', 'country', 'phone', 'email');

    foreach ($arrKeys as $k => $v) {
      $sheet->setCellValue(chr(65 + $k) . '1', $GLOBALS['TL_LANG']['tl_iso_product_collection']['csv_head'][$v]);
    }

    $objOrders = \Database::getInstance()->prepare("SELECT tl_iso_address.* 
                                                    FROM tl_iso_product_collection, tl_iso_address 
                                                    WHERE tl_iso_product_collection.billing_address_id = tl_iso_address.id 
                                                      AND type = 'order'
                                                      AND locked >= ? 
                                                      AND locked <= ?
                                                    GROUP BY member")
                                         ->execute(strtotime($dateFrom . " 00:00:00"), strtotime($dateTo . " 23:59:59")); 

    if (null === $objOrders) {
      return '<p class="tl_error">'. $GLOBALS['TL_LANG']['MSC']['noOrders'] .'</p>';
    }

    $row = 2;
    while ($objOrders->next()) {
      $sheet->setCellValue('A' . $row, $objOrders->company);
      $sheet->setCellValue('B' . $row, $objOrders->lastname);
      $sheet->setCellValue('C' . $row, $objOrders->firstname);
      $sheet->setCellValue('D' . $row, $objOrders->street_1);
      $sheet->setCellValue('E' . $row, $objOrders->postal);
      $sheet->setCellValue('F' . $row, $objOrders->city);
      $sheet->setCellValue('G' . $row, $GLOBALS['TL_LANG']['CNT'][$objOrders->country]);
      $sheet->setCellValue('H' . $row, $objOrders->phone);
      $sheet->setCellValue('I' . $row, $objOrders->email);
      $row++;
    }
  
    // Output
    $this->saveToBrowser($spreadsheet, $format, $separator);
  }  
  
  
  /**
   * Save the file to the browser
   * @param Spreadsheet $spreadsheet
   * @param string $format
   * @param string $separator
   * @return void
   */   
  protected function saveToBrowser($spreadsheet, $format, $separator) 
  {  
    // Setze die HTTP-Header für den Download
    switch ($format) {
      case 'csv':
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment;filename="export.csv"');
        header('Cache-Control: max-age=0');
        $writer = new Csv($spreadsheet);
        $writer->setDelimiter($separator === 'comma' ? ',' : ($separator === 'semicolon' ? ';' : ($separator === 'tabulator' ? "\t" : "\n")));
        $writer->save('php://output');
        break;
      case 'xlsx':
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="export.xlsx"');
        header('Cache-Control: max-age=0');
        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
        break;
      case 'ods':
        header('Content-Type: application/vnd.oasis.opendocument.spreadsheet');
        header('Content-Disposition: attachment;filename="export.ods"');
        header('Cache-Control: max-age=0');
        $writer = new Ods($spreadsheet);
        $writer->save('php://output');
        break;
      default:
        throw new Exception('Unsupported format: ' . $format);  
    }

    // Notiz anzeigen
    Message::addConfirmation('Export erfolgreich!');

    exit;
  }
}
