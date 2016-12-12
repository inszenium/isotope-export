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

/**
 * Table tl_iso_product_collection
 */

$GLOBALS['TL_DCA']['tl_iso_product_collection']['list']['global_operations']['export'] = array
(
  'label'         => &$GLOBALS['TL_LANG']['tl_iso_product_collection']['export'],
  'href'          => '',
  'class'         => 'header_isotope-export',
  'attributes'    => 'onclick="Backend.getScrollOffset();" style="display:none"',
);

$GLOBALS['TL_DCA']['tl_iso_product_collection']['list']['global_operations']['export_information'] = array
(
  'label'         => &$GLOBALS['TL_LANG']['tl_iso_product_collection']['export_information'],
  'class'         => 'header_iso_export_csv isotope-export infobox',
);



$GLOBALS['TL_DCA']['tl_iso_product_collection']['list']['global_operations']['export_orders'] = array
(
  'label'         => &$GLOBALS['TL_LANG']['tl_iso_product_collection']['export_orders'],
  'href'          => 'key=export_orders',
  'class'         => 'header_iso_export_csv isotope-export',
  'attributes'    => 'onclick="Backend.getScrollOffset();"'
);

$GLOBALS['TL_DCA']['tl_iso_product_collection']['list']['global_operations']['export_items'] = array
(
  'label'         => &$GLOBALS['TL_LANG']['tl_iso_product_collection']['export_items'],
  'href'          => 'key=export_items',
  'class'         => 'header_iso_export_csv isotope-export',
  'attributes'    => 'onclick="Backend.getScrollOffset();"'
);

$GLOBALS['TL_DCA']['tl_iso_product_collection']['list']['global_operations']['export_bank'] = array
(
  'label'         => &$GLOBALS['TL_LANG']['tl_iso_product_collection']['export_bank'],
  'href'          => 'key=export_bank',
  'class'         => 'header_iso_export_csv isotope-export',
  'attributes'    => 'onclick="Backend.getScrollOffset();"'
);

$GLOBALS['TL_DCA']['tl_iso_product_collection']['list']['global_operations']['export_excel_orders'] = array
(
  'label'         => &$GLOBALS['TL_LANG']['tl_iso_product_collection']['export_excel_orders'],
  'href'          => 'key=export_orders&excel=true',
  'class'         => 'header_iso_export_csv isotope-export',
  'attributes'    => 'onclick="Backend.getScrollOffset();"'
);

$GLOBALS['TL_DCA']['tl_iso_product_collection']['list']['global_operations']['export_excel_items'] = array
(
  'label'         => &$GLOBALS['TL_LANG']['tl_iso_product_collection']['export_excel_items'],
  'href'          => 'key=export_items&excel=true',
  'class'         => 'header_iso_export_csv isotope-export',
  'attributes'    => 'onclick="Backend.getScrollOffset();"'
);

$GLOBALS['TL_DCA']['tl_iso_product_collection']['list']['global_operations']['export_excel_bank'] = array
(
  'label'         => &$GLOBALS['TL_LANG']['tl_iso_product_collection']['export_excel_bank'],
  'href'          => 'key=export_bank&excel=true',
  'class'         => 'header_iso_export_csv isotope-export',
  'attributes'    => 'onclick="Backend.getScrollOffset();"'
);
