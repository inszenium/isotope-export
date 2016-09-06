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

/**
 * BACK END MODULES
 */ 
$GLOBALS['BE_MOD']['isotope']['iso_orders']['export_orders'] = array('Isotope\Collection\IsotopeOrderExport', 'exportOrders');
$GLOBALS['BE_MOD']['isotope']['iso_orders']['export_items']  = array('Isotope\Collection\IsotopeOrderExport', 'exportItems');
$GLOBALS['BE_MOD']['isotope']['iso_orders']['export_bank']   = array('Isotope\Collection\IsotopeOrderExport', 'exportBank');


if (TL_MODE == 'BE')
{
    $GLOBALS['TL_CSS'][] = \Haste\Util\Debug::uncompressedFile('system/modules/isotope-order_export/assets/css/backend.css|static');
    $GLOBALS['TL_JAVASCRIPT'][] = \Haste\Util\Debug::uncompressedFile('system/modules/isotope-order_export/assets/js/backend.js|static');
}
