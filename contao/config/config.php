<?php

declare(strict_types=1);

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


/**
 * BACK END MODULES
 */ 
$GLOBALS['BE_MOD']['isotope']['iso_orders']['export'] = array('Inszenium\IsotopeExport\OrderExport', 'exportOrders');
//$GLOBALS['BE_MOD']['isotope']['iso_orders']['stylesheet'] = 'system/modules/isotope_export/assets/css/backend.css';