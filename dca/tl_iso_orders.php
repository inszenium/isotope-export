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
 * Table tl_iso_orders
 */

$GLOBALS['TL_DCA']['tl_iso_orders']['list']['global_operations']['export_orders'] = array
(
  'label'         => &$GLOBALS['TL_LANG']['tl_iso_orders']['export_orders'],
  'href'          => 'key=export_orders',
  'class'         => 'header_iso_export_csv isotope-tools',
  'attributes'    => 'onclick="Backend.getScrollOffset();"'
);

$GLOBALS['TL_DCA']['tl_iso_orders']['list']['global_operations']['export_items'] = array
(
  'label'         => &$GLOBALS['TL_LANG']['tl_iso_orders']['export_items'],
  'href'          => 'key=export_items',
  'class'         => 'header_iso_export_csv isotope-tools',
  'attributes'    => 'onclick="Backend.getScrollOffset();"'
);

$GLOBALS['TL_DCA']['tl_iso_orders']['list']['global_operations']['export_bank'] = array
(
  'label'         => &$GLOBALS['TL_LANG']['tl_iso_orders']['export_bank'],
  'href'          => 'key=export_bank',
  'class'         => 'header_iso_export_csv isotope-tools',
  'attributes'    => 'onclick="Backend.getScrollOffset();"'
);

    
    
    
    
