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
   * An array with contains the fields
   * @var array
   */
  protected $arrContent = array();


  /**
   * An array with the header fields
   * @var array
   */
  protected $arrHeaderFields = array();

  
  /**
   * The field delimiter
   * @var string
   */
  protected $strDelimiter = '"';


  /**
   * The field seperator
   * @var string
   */
  protected $strSeperator = ';';


  /**
   * The line end
   * @var string
   */
  protected $strLineEnd = "\r\n";


  /**
   * Import an Isotope object
   */
  public function __construct()
  {
    parent::__construct();
    \System::loadLanguageFile('countries');
  }
  
  
  /**
   * Generate the csv file and send it to the browser
   *
   * @param void
   * @return void
   */
  public function saveToBrowser()
  {
	if ( count($this->arrContent) < 1 ) {
	  $strRequest = ampersand(str_replace('&key=export_order', '', $this->Environment->request));	
	  $strRequest = ampersand(str_replace('&excel=true', '', $strRequest));	
	  
      return '<div id="tl_buttons">
          <a href="'.$strRequest.'" class="header_back" title="'.specialchars($GLOBALS['TL_LANG']['MSC']['backBT']).'">'.$GLOBALS['TL_LANG']['MSC']['backBT'].'</a>
          </div>
          <p class="tl_gerror">'. $GLOBALS['TL_LANG']['MSC']['noOrders'] .'</p>';
    }     
	  
    $strContent = $this->prepareContent();

    header('Content-Type: text/csv');
    header('Content-Transfer-Encoding: binary');
    header('Content-Disposition: attachment; filename="isotope_items_export_' . $this->parseDate($GLOBALS['TL_CONFIG']['dateFormat'], time()) . '_' . $this->parseDate($GLOBALS['TL_CONFIG']['timeFormat'], time()) .'.csv"');
    header('Content-Length: ' . strlen($strContent));
    header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
    header('Pragma: public');
    header('Expires: 0');

    echo $strContent;
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
     
    foreach ($arrKeys as $v) {
      $this->arrHeaderFields[$v] = $csvHead[$v];
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
      if( strlen($arrOrderItems[$objOrderItems->pid]) > 0 ) {
        $arrOrderItems[$objOrderItems->pid] .= PHP_EOL;
      }
          
      $arrOrderItems[$objOrderItems->pid] .= html_entity_decode( 
                                        $objOrderItems->quantity . " x " . strip_tags($objOrderItems->name) . " [" . $objOrderItems->sku . "] " .
                                        " á " . strip_tags(Isotope::formatPriceWithCurrency($objOrderItems->price)) .  
                                        " (" . strip_tags(Isotope::formatPriceWithCurrency($objOrderItems->quantity * $objOrderItems->price)) . ")"
                                      );      
    }

    while ($objOrders->next()) {
      if( isset($arrOrderItems) && is_array($arrOrderItems) && !array_key_exists($objOrders->collection_id, $arrOrderItems) ) { continue; }

      $this->arrContent[] = array(    
        'order_id'      => $objOrders->document_number,
        'date'          => $this->parseDate($GLOBALS['TL_CONFIG']['datimFormat'], $objOrders->locked),
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
    $this->saveToBrowser();
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
    $arrKeys = array('order_id', 'date', 'company', 'lastname', 'firstname', 'street', 'postal', 'city', 'country', 'phone', 'email', 'count', 'item_sku', 'item_name', 'item_configuration', 'item_price', 'sum');
   
    foreach ($arrKeys as $v) {
      $this->arrHeaderFields[$v] = $csvHead[$v];
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
	  $arrConfig = deserialize($objOrderItems->configuration);
	  $strConfig = '';
	  if(is_array($arrConfig)) {
		foreach ($arrConfig as $key => $value) {
		  if( strlen($strConfig) > 1 ) {
			$strConfig .= PHP_EOL;
		  }	
		  $arrValues = deserialize($value);
		  $strConfig .= \Isotope\Translation::get($key) . ": " . (is_array($arrValues) ? implode(",", $arrValues) : \Isotope\Translation::get($value));
		}	
	  }	
		
		                
      $arrOrderItems[$objOrderItems->pid][] = array
      (
        'count'         => $objOrderItems->quantity,
        'item_sku'      => html_entity_decode( $objOrderItems->sku ),
        'item_name'     => strip_tags(html_entity_decode($objOrderItems->name)),
        'item_price'    => strip_tags(html_entity_decode(Isotope::formatPriceWithCurrency($objOrderItems->price))),
        'configuration' => strip_tags(html_entity_decode($strConfig)),
        'sum'           => strip_tags(html_entity_decode(Isotope::formatPriceWithCurrency($objOrderItems->quantity * $objOrderItems->price))),    
      );    
    }

    while ($objOrders->next()) {
      if( isset($arrOrderItems) && is_array($arrOrderItems) && !array_key_exists($objOrders->collection_id, $arrOrderItems) ) { continue; }
  
      foreach ($arrOrderItems[$objOrders->collection_id] as $item) {
        $this->arrContent[] = array(
          'order_id'           => $objOrders->document_number,
          'date'               => $this->parseDate($GLOBALS['TL_CONFIG']['datimFormat'], $objOrders->locked),
          'company'            => $objOrders->company, 
          'lastname'           => $objOrders->lastname, 
          'firstname'          => $objOrders->firstname,
          'street'             => $objOrders->street_1, 
          'postal'             => $objOrders->postal, 
          'city'               => $objOrders->city, 
          'country'            => $GLOBALS['TL_LANG']['CNT'][$objOrders->country],
          'phone'              => $objOrders->phone, 
          'email'              => $objOrders->email,
          'count'              => $item['count'],
          'item_sku'           => $item['item_sku'],
          'item_name'          => $item['item_name'],
          'item_configuration' => $item['configuration'],
          'item_price'         => $item['item_price'],
          'item_sum'           => $item['sum'],
        );
      }         
    }
    
    // Output
    $this->saveToBrowser();
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
      $this->arrHeaderFields[$v] = $csvHead[$v];
    }

    $objOrders = \Database::getInstance()->query("SELECT tl_iso_address.* FROM tl_iso_product_collection, tl_iso_address WHERE tl_iso_product_collection.billing_address_id = tl_iso_address.id AND ( document_number != '' OR document_number IS NOT NULL) GROUP BY member");

    if (null === $objOrders) {
      return '<div id="tl_buttons">
          <a href="'.ampersand(str_replace('&key=export_order', '', $this->Environment->request)).'" class="header_back" title="'.specialchars($GLOBALS['TL_LANG']['MSC']['backBT']).'">'.$GLOBALS['TL_LANG']['MSC']['backBT'].'</a>
          </div>
          <p class="tl_gerror">'. $GLOBALS['TL_LANG']['MSC']['noOrders'] .'</p>';
    }

    while ($objOrders->next()) {      
      $this->arrContent[$objOrders->id] = array(
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
    $this->saveToBrowser();
  }  
  
  
  /**
   * Prepare the given array and build the content stream
   *
   * @param void
   * @return string
   */
  public function prepareContent()
  {
    $strCsv = '';
    $arrData = array();

    // add the header fields if there are some
    if (count($this->arrHeaderFields)>0) {
      $arrData = array($this->arrHeaderFields);
    }

    // add all other elements
    foreach ($this->arrContent as $k=>$v) {
      //TODO: maybe find a better solution
      $arrData[] = $v;
    }


    // build the csv string
    foreach((array) $arrData as $arrRow) {
      array_walk($arrRow, array($this, 'escapeRow'));
      $strCsv .= $this->strDelimiter . implode($this->strDelimiter . $this->strSeperator . $this->strDelimiter, $arrRow) . $this->strDelimiter . $this->strLineEnd;
    }

    // add the excel support if requested
    if ($this->Input->get('excel')) {
      $strCsv = chr(255) . chr(254) . mb_convert_encoding($strCsv, 'UTF-16LE', 'UTF-8');
    }

    return $strCsv;
  }
  
  /**
   * Escape a row
   *
   * @param mixed &$varValue
   * @return void
   */
  public function escapeRow(&$varValue)
  {
    $varValue = str_replace('"', '""', $varValue);
  }
}
