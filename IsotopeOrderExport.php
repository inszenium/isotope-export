<?php if (!defined('TL_ROOT')) die('You can not access this file directly!');

/**
 * IsotopeOrderExport
 *
 * @copyright  Kirsten Roschanski 2013 <http://kirsten-roschanski.de>
 * @author     Kirsten Roschanski <kirsten.roschanski@kirsten-roschanski.de>
 * @package    IsotopeOrderExport
 * @license    LGPL 
 * @link       https://github.com/katgirl/isotope_order_export
 * @filesource
 */

/**
 * Class IsotopeOrderExport
 * Provide miscellaneous methods that are used by the data configuration array.
 */
class IsotopeOrderExport extends Backend
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
    $this->import('Isotope');
    $this->loadLanguageFile('countries');
  }
  
  /**
   * CSV output
   * @param array
   */
  private function csv_output()
  {
    if ( count($this->arrExport) > 1 )
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

    foreach ($this->arrExport as $export)
    {
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
    if ($this->Input->get('key') != 'export_orders')
    {
      return '';
    }

    $csvHead = &$GLOBALS['TL_LANG']['tl_iso_orders']['csv_head'];
    $arrKeys = array('order_id', 'date', 'company', 'lastname', 'firstname', 'street', 'postal', 'city', 'country', 'phone', 'email', 'items', 'grandTotal');
     
    foreach ($arrKeys as $v)
    {
            $this->arrExport[$v] = $csvHead[$v];
    }
    
    $objOrders = $this->Database->query("SELECT * FROM tl_iso_orders ORDER BY order_id ASC");
    $objOrderItems = $this->Database->query("SELECT * FROM tl_iso_order_items")->fetchAllAssoc();
    
    $arrOrderItems = array();
    foreach ( $objOrderItems as $items )
    {  
      if( strlen($arrOrderItems[$items['pid']] > 0) )
      {
        $arrOrderItems[$items['pid']] .= PHP_EOL;
      }
          
      $arrOrderItems[$items['pid']] .= html_entity_decode( 
                                        $items['product_quantity'] . " x " . $items['product_name'] .  
                                        " á " . strip_tags($this->Isotope->formatPriceWithCurrency($items['price'])) .  
                                        " (" . strip_tags($this->Isotope->formatPriceWithCurrency($items['product_quantity'] * $items['price'])) . ")"
                                      );      
    }

    while ($objOrders->next())
    {
      $arrAddress = deserialize($objOrders->billing_address);

      $this->arrExport[] = array(    
        'order_id'      => $objOrders->order_id,
        'date'          => $this->parseDate($GLOBALS['TL_CONFIG']['datimFormat'], $objOrders->date),
        'company'       => $arrAddress['company'], 
        'lastname'      => $arrAddress['lastname'], 
        'firstname'     => $arrAddress['firstname'],
        'street'        => $arrAddress['street_1'],
        'postal'        => $arrAddress['postal'],
        'city'          => $arrAddress['city'],
        'country'       => $GLOBALS['TL_LANG']['CNT'][$arrAddress['country']],
        'phone'         => $arrAddress['phone'], 
        'email'         => $arrAddress['email'], 
        'items'         => $arrOrderItems[$objOrders->id],
        'subTotal'      => strip_tags($this->Isotope->formatPriceWithCurrency($objOrders->subTotal)),
        'taxTotal'      => strip_tags($this->Isotope->formatPriceWithCurrency($objOrders->taxTotal)),
        'grandTotal'    => strip_tags($this->Isotope->formatPriceWithCurrency($objOrders->grandTotal)),
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
    if ($this->Input->get('key') != 'export_items')
    {
      return '';
    }

    $csvHead = &$GLOBALS['TL_LANG']['tl_iso_orders']['csv_head'];
    $arrKeys = array('order_id', 'date', 'company', 'lastname', 'firstname', 'street', 'postal', 'city', 'country', 'phone', 'email', 'count', 'item_name', 'item_price', 'sum');
     
    foreach ($arrKeys as $v)
    {
            $this->arrExport[$v] = $csvHead[$v];
    }
    
    $objOrders = $this->Database->query("SELECT * FROM tl_iso_orders ORDER BY order_id ASC");
    $objOrderItems = $this->Database->query("SELECT * FROM tl_iso_order_items")->fetchAllAssoc();
    
    $arrOrderItems = array();
    foreach ( $objOrderItems as $items )
    {            
      $arrOrderItems[$items['pid']][] = array
      (
        'count'         => $items['product_quantity'],
        'item_name'     => html_entity_decode( $items['product_name'] ),
        'item_price'    => strip_tags($this->Isotope->formatPriceWithCurrency($items['price'])),
        'sum'           => strip_tags($this->Isotope->formatPriceWithCurrency($items['product_quantity'] * $items['price'])),    
      );    
    }

    while ($objOrders->next())
    {
      $arrAddress = deserialize($objOrders->billing_address);
  
      foreach ($arrOrderItems[$objOrders->id] as $item)
      {
        $this->arrExport[] = array(
          'order_id'      => $objOrders->order_id,
          'date'          => $this->parseDate($GLOBALS['TL_CONFIG']['datimFormat'], $objOrders->date),
          'company'       => $arrAddress['company'], 
          'lastname'      => $arrAddress['lastname'], 
          'firstname'     => $arrAddress['firstname'],
          'street'        => $arrAddress['street_1'], 
          'postal'        => $arrAddress['postal'], 
          'city'          => $arrAddress['city'], 
          'country'       => $GLOBALS['TL_LANG']['CNT'][$arrAddress['country']],
          'phone'         => $arrAddress['phone'], 
          'email'         => $arrAddress['email'], 
          'count'         => $item['count'],
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
    if ($this->Input->get('key') != 'export_bank')
    {
      return '';
    }

    $csvHead = &$GLOBALS['TL_LANG']['tl_iso_orders']['csv_head'];
    $arrKeys = array('company', 'lastname', 'firstname', 'street', 'postal', 'city', 'country', 'phone', 'email');
     
    foreach ($arrKeys as $v)
    {
            $this->arrExport[$v] = $csvHead[$v];
    }

    $objOrders = $this->Database->query("SELECT billing_address FROM tl_iso_orders ORDER BY order_id ASC");

    while ($objOrders->next())
    {
      $arrAddress = deserialize($objOrders->billing_address);
  
      $this->arrExport[$arrAddress['company']] = array(
        'company'       => $arrAddress['company'], 
        'lastname'      => $arrAddress['lastname'], 
        'firstname'     => $arrAddress['firstname'],
        'street'        => $arrAddress['street_1'], 
        'postal'        => $arrAddress['postal'], 
        'city'          => $arrAddress['city'], 
        'country'       => $GLOBALS['TL_LANG']['CNT'][$arrAddress['country']],
        'phone'         => $arrAddress['phone'], 
        'email'         => $arrAddress['email'],
      );       
    }
    
    // Output
    $this->csv_output();
  }  
}
