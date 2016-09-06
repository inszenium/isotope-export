<?php

/**
 * IsotopeOrderExport
 *
 * @copyright  centerscreen gmbh 2016 <https://www.center-screen.de>
 * @author     Kirsten Roschanski <git@kirsten-roschanski.de>
 * @package    IsotopeOrderExport
 * @license    LGPL 
 * @link       https://github.com/center-screen/isotope-order_export
 * @filesource
 */

namespace Isotope\Collection;
use Isotope\Isotope;
use Isotope\Interfaces\IsotopeProduct;

/**
 * Class IsotopeOrderExport
 * Provide miscellaneous methods that are used by the data configuration array.
 */
class IsotopeOrderExport extends \Backend
{
  /**
   * Exportdata 
   * @var array
   */
  protected $arrExport = array();

  /**
   * Import an Isotope object
   */
  public function __construct()
  {
    parent::__construct();
    \System::loadLanguageFile('countries');
  }
  
  /**
   * CSV output
   * @param array
   */
  private function csv_output()
  {
    
    if ( count($this->arrExport) < 2 )
    {
      return '<div id="tl_buttons">
          <a href="'.ampersand(str_replace('&key=export_order', '', $this->Environment->request)).'" class="header_back" title="'.specialchars($GLOBALS['TL_LANG']['MSC']['backBT']).'">'.$GLOBALS['TL_LANG']['MSC']['backBT'].'</a>
          </div>
          <p class="tl_gerror">'. $GLOBALS['TL_LANG']['MSC']['noOrders'] .'</p>';
    }    
    
    header('Content-Type: application/csv');
    header('Content-Transfer-Encoding: binary');
    header('Content-Disposition: attachment; filename="isotope_items_export_' . $this->parseDate($GLOBALS['TL_CONFIG']['dateFormat'], time()) . '_' . $this->parseDate($GLOBALS['TL_CONFIG']['timeFormat'], time()) .'.csv"');
    header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
    header('Pragma: public');
    header('Expires: 0');

    $output = '';

    foreach ($this->arrExport as $export) {
      $output .= '"' . implode( "\";\"", $export ) . "\"\n";
    }

    echo $output;
    exit;
  }
  
  /**
   * Export orders and send them to browser as file
   * @param DataContainer
   * @return string
   */
  public function exportOrders()
  {    
    if ($this->Input->get('key') != 'export_orders') {
      return '';
    }

    $csvHead = &$GLOBALS['TL_LANG']['tl_iso_product_collection']['csv_head'];
    $arrKeys = array('order_id', 'date', 'company', 'lastname', 'firstname', 'street', 'postal', 'city', 'country', 'phone', 'email', 'items', 'grandTotal');
     
    foreach ($arrKeys as $v)
    {
      $this->arrExport['head'][$v] = $csvHead[$v];
    }
   
    $objOrders = \Database::getInstance()->query("SELECT *, tl_iso_product_collection.id as collection_id FROM tl_iso_product_collection, tl_iso_address WHERE tl_iso_product_collection.billing_address_id = tl_iso_address.id AND ( document_number != '' OR document_number IS NOT NULL) ORDER BY document_number ASC");

    if (null === $objOrders) {
       return '<div id="tl_buttons">
          <a href="'.ampersand(str_replace('&key=export_order', '', $this->Environment->request)).'" class="header_back" title="'.specialchars($GLOBALS['TL_LANG']['MSC']['backBT']).'">'.$GLOBALS['TL_LANG']['MSC']['backBT'].'</a>
          </div>
          <p class="tl_gerror">'. $GLOBALS['TL_LANG']['MSC']['noOrders'] .'</p>';
    } 

    $objOrderItems = \Database::getInstance()->query("SELECT * FROM tl_iso_product_collection_item");
    
    $arrOrderItems = array();
    
    while ($objOrderItems->next()){  
    // wenn schon ein Produkt da ist, dann einen Zeilenumbruch machen für Excel  
      if( strlen($arrOrderItems[$objOrderItems->pid] > 0) ) {
        $arrOrderItems[$objOrderItems->pid] .= PHP_EOL;
      }
          
      $arrOrderItems[$objOrderItems->pid] .= html_entity_decode( 
                                        $objOrderItems->quantity . " x " . strip_tags($objOrderItems->name) . " [" . $objOrderItems->sku . "] " .
                                        " á " . strip_tags(Isotope::formatPriceWithCurrency($objOrderItems->price)) .  
                                        " (" . strip_tags(Isotope::formatPriceWithCurrency($objOrderItems->quantity * $objOrderItems->price)) . ")"
                                      );      
    }

    while ($objOrders->next())
    {
      if( isset($arrOrderItems) && is_array($arrOrderItems) && !array_key_exists($objOrders->collection_id, $arrOrderItems) ) { continue; }

      $this->arrExport[] = array(    
        'order_id'      => $objOrders->document_number,
        'date'          => $this->parseDate($GLOBALS['TL_CONFIG']['datimFormat'], $objOrders->date),
        'company'       => $objOrders->company, 
        'lastname'      => $objOrders->lastname, 
        'firstname'     => $objOrders->firstname,
        'street'        => $objOrders->street_1, 
        'postal'        => $objOrders->postal, 
        'city'          => $objOrders->city, 
        'country'       => $GLOBALS['TL_LANG']['CNT'][$objOrders->country],
        'phone'         => $objOrders->phone, 
        'email'         => $objOrders->email,
        'items'         => $arrOrderItems[$objOrders->collection_id],
        'subTotal'      => strip_tags(html_entity_decode(Isotope::formatPriceWithCurrency($objOrders->subTotal))),
        'taxTotal'      => strip_tags(html_entity_decode(Isotope::formatPriceWithCurrency($objOrders->tax_free_subtotal))),
        'grandTotal'    => strip_tags(html_entity_decode(Isotope::formatPriceWithCurrency($objOrders->total))),
      );         
    }
    
    // Output
    $this->csv_output();
  }
  
  
  /**
   * Export orders and send them to browser as file
   * @param DataContainer
   */
  public function exportItems()
  {    
    if ($this->Input->get('key') != 'export_items') {
      return '';
    }

    $csvHead = &$GLOBALS['TL_LANG']['tl_iso_product_collection']['csv_head'];
    $arrKeys = array('order_id', 'date', 'company', 'lastname', 'firstname', 'street', 'postal', 'city', 'country', 'phone', 'email', 'count', 'item_sku', 'item_name', 'item_price', 'sum');
   
    foreach ($arrKeys as $v) {
      $this->arrExport['head'][$v] = $csvHead[$v];
    } 
   
    $objOrders = \Database::getInstance()->query("SELECT *, tl_iso_product_collection.id as collection_id FROM tl_iso_product_collection, tl_iso_address WHERE tl_iso_product_collection.billing_address_id = tl_iso_address.id AND ( document_number != '' OR document_number IS NOT NULL) ORDER BY document_number ASC");

    if (null === $objOrders) {
      return '<div id="tl_buttons">
          <a href="'.ampersand(str_replace('&key=export_order', '', $this->Environment->request)).'" class="header_back" title="'.specialchars($GLOBALS['TL_LANG']['MSC']['backBT']).'">'.$GLOBALS['TL_LANG']['MSC']['backBT'].'</a>
          </div>
          <p class="tl_gerror">'. $GLOBALS['TL_LANG']['MSC']['noOrders'] .'</p>';
    }
    
    $objOrderItems = \Database::getInstance()->query("SELECT * FROM tl_iso_product_collection_item");      
    
    $arrOrderItems = array();
    while ($objOrderItems->next()) {                  
      $arrOrderItems[$objOrderItems->pid][] = array
      (
        'count'         => $objOrderItems->quantity,
        'item_sku'      => html_entity_decode( $objOrderItems->sku ),
        'item_name'     => strip_tags(html_entity_decode( $objOrderItems->name )),
        'item_price'    => strip_tags(html_entity_decode(Isotope::formatPriceWithCurrency($objOrderItems->price))),
        'sum'           => strip_tags(html_entity_decode(Isotope::formatPriceWithCurrency($objOrderItems->quantity * $objOrderItems->price))),    
      );    
    }

    while ($objOrders->next()) {
      if( isset($arrOrderItems) && is_array($arrOrderItems) && !array_key_exists($objOrders->collection_id, $arrOrderItems) ) { continue; }
  
      foreach ($arrOrderItems[$objOrders->collection_id] as $item) {
        $this->arrExport[] = array(
          'order_id'      => $objOrders->document_number,
          'date'          => $this->parseDate($GLOBALS['TL_CONFIG']['datimFormat'], $objOrders->date),
          'company'       => $objOrders->company, 
          'lastname'      => $objOrders->lastname, 
          'firstname'     => $objOrders->firstname,
          'street'        => $objOrders->street_1, 
          'postal'        => $objOrders->postal, 
          'city'          => $objOrders->city, 
          'country'       => $GLOBALS['TL_LANG']['CNT'][$objOrders->country],
          'phone'         => $objOrders->phone, 
          'email'         => $objOrders->email,
          'count'         => $item['count'],
          'item_sku'      => $item['item_sku'],
          'item_name'     => $item['item_name'],
          'item_price'    => $item['item_price'],
          'sum'           => $item['sum'],
        );
      }         
    }
    
    // Output
    $this->csv_output();
  }  
  
  /**
   * Export orders and send them to browser as file
   * @param DataContainer
   */
  public function exportBank()
  {    
    if ($this->Input->get('key') != 'export_bank') {
      return '';
    }

    $csvHead = &$GLOBALS['TL_LANG']['tl_iso_product_collection']['csv_head'];
    $arrKeys = array('company', 'lastname', 'firstname', 'street', 'postal', 'city', 'country', 'phone', 'email');
     
    foreach ($arrKeys as $v) {
      $this->arrExport['head'][$v] = $csvHead[$v];
    }

    $objOrders = \Database::getInstance()->query("SELECT tl_iso_address.* FROM tl_iso_product_collection, tl_iso_address WHERE tl_iso_product_collection.billing_address_id = tl_iso_address.id AND ( document_number != '' OR document_number IS NOT NULL) GROUP BY member");

    if (null === $objOrders) {
      return '<div id="tl_buttons">
          <a href="'.ampersand(str_replace('&key=export_order', '', $this->Environment->request)).'" class="header_back" title="'.specialchars($GLOBALS['TL_LANG']['MSC']['backBT']).'">'.$GLOBALS['TL_LANG']['MSC']['backBT'].'</a>
          </div>
          <p class="tl_gerror">'. $GLOBALS['TL_LANG']['MSC']['noOrders'] .'</p>';
    }

    while ($objOrders->next()) {      
      $this->arrExport[$objOrders->id] = array(
        'company'       => $objOrders->company, 
        'lastname'      => $objOrders->lastname, 
        'firstname'     => $objOrders->firstname,
        'street'        => $objOrders->street_1, 
        'postal'        => $objOrders->postal, 
        'city'          => $objOrders->city, 
        'country'       => $GLOBALS['TL_LANG']['CNT'][$objOrders->country],
        'phone'         => $objOrders->phone, 
        'email'         => $objOrders->email,
      );       
    }
  
    // Output
    $this->csv_output();
  }  
}
