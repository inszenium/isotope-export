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
 * BACK END MODULES
 */ 
$GLOBALS['BE_MOD']['isotope']['iso_orders']['export_orders'] = array('IsotopeOrderExport', 'exportOrders');
$GLOBALS['BE_MOD']['isotope']['iso_orders']['export_items']  = array('IsotopeOrderExport', 'exportItems');
$GLOBALS['BE_MOD']['isotope']['iso_orders']['export_bank']   = array('IsotopeOrderExport', 'exportBank');
