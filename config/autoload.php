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


if (class_exists('NamespaceClassLoader')) {
    /**
     * Register PSR-0 namespace
     */
    NamespaceClassLoader::add('Isotope', 'system/modules/isotope_export/library');
}
