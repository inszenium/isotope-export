<?php if (!defined('TL_ROOT')) die('You can not access this file directly!');

/**
 * Contao Open Source CMS
 * Copyright (C) 2005-2013 Leo Feyer
 *
 * Formerly known as TYPOlight Open Source CMS.
 *
 * This program is free software: you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation, either
 * version 3 of the License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU
 * Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public
 * License along with this program. If not, please visit the Free
 * Software Foundation website at <http://www.gnu.org/licenses/>.
 *
 * PHP version 5
 * @copyright  
 * @author     
 * @license    http://opensource.org/licenses/lgpl-3.0.html
 */

/**
 * Table tl_iso_orders
 */

$GLOBALS['TL_DCA']['tl_iso_orders']['list']['global_operations']['export_orders'] = array
(
	'label'				=> &$GLOBALS['TL_LANG']['tl_iso_orders']['export_orders'],
	'href'				=> 'key=export_orders',
	'class'				=> 'header_iso_export_csv isotope-tools',
	'attributes'		=> 'onclick="Backend.getScrollOffset();"'
);

$GLOBALS['TL_DCA']['tl_iso_orders']['list']['global_operations']['export_items'] = array
(
	'label'				=> &$GLOBALS['TL_LANG']['tl_iso_orders']['export_items'],
	'href'				=> 'key=export_items',
	'class'				=> 'header_iso_export_csv isotope-tools',
	'attributes'		=> 'onclick="Backend.getScrollOffset();"'
);

/**
 * Class iso_orders_export
 * Provide miscellaneous methods that are used by the data configuration array.
 */
class iso_orders_export extends Backend
{

	/**
	 * Import an Isotope object
	 */
	public function __construct()
	{
		parent::__construct();
		$this->import('Isotope');
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

		$arrExport = array();
		$arrExport[] = array(
			'order_id'		  => $GLOBALS['TL_LANG']['tl_iso_orders']['csv_head']['order_id'],	
			'date'			    => $GLOBALS['TL_LANG']['tl_iso_orders']['csv_head']['date'],		
			'lastname'	 	  => $GLOBALS['TL_LANG']['tl_iso_orders']['csv_head']['lastname'],	
			'firstname' 	  => $GLOBALS['TL_LANG']['tl_iso_orders']['csv_head']['firstname'],	
			'street'	 	    => $GLOBALS['TL_LANG']['tl_iso_orders']['csv_head']['street'],	
			'postal'	 	    => $GLOBALS['TL_LANG']['tl_iso_orders']['csv_head']['postal'],	
			'city'		 	    => $GLOBALS['TL_LANG']['tl_iso_orders']['csv_head']['city'],	
			'phone'		 	    => $GLOBALS['TL_LANG']['tl_iso_orders']['csv_head']['phone'],	
			'email'		 	    => $GLOBALS['TL_LANG']['tl_iso_orders']['csv_head']['email'],	
			'items'			    => $GLOBALS['TL_LANG']['tl_iso_orders']['csv_head']['items'],
			'grandTotal'	  => $GLOBALS['TL_LANG']['tl_iso_orders']['csv_head']['grandTotal'],
		);
		
		$objOrders = $this->Database->execute("SELECT * FROM tl_iso_orders ORDER BY order_id ASC");
		$objOrderItems = $this->Database->execute("SELECT * FROM tl_iso_order_items")->fetchAllAssoc();
		
		$arrOrderItems = array();
		foreach ( $objOrderItems as $items )
		{	
			if( strlen($arrOrderItems[$items['pid']] > 0) )
			{
				$arrOrderItems[$items['pid']] .= "\n";
			}
					
			$arrOrderItems[$items['pid']] .= html_entity_decode( 
                                        $items['product_quantity'] . " x " . $items['product_name'] .  
                                        " á " . $this->Isotope->formatPriceWithCurrency($items['price']) .  
                                        " (" . $this->Isotope->formatPriceWithCurrency($items['product_quantity'] * $items['price']) . ")"
                                      );			
		}

		while ($objOrders->next())
		{
			$arrAddress = deserialize($objOrders->billing_address);

			$arrExport[] = array(
				'order_id'		=> $objOrders->order_id,
				'date'			  => $this->parseDate($GLOBALS['TL_CONFIG']['datimFormat'], $objOrders->date),
				'member'	    => $arrAddress['district'] != '' ? $GLOBALS['TL_LANG']['tl_iso_orders']['member'] : $GLOBALS['TL_LANG']['tl_iso_orders']['other'],
				'district'	  => $arrDistrict[$arrAddress['district']], 
				'community'	  => $arrCommunity[$arrAddress['district']][$arrAddress['community']],
				'lastname'	 	=> $arrAddress['lastname'], 
				'firstname' 	=> $arrAddress['firstname'],
				'street'	 	  => $arrAddress['street_1'], 
				'postal'	 	  => $arrAddress['postal'], 
				'city'		 	  => $arrAddress['city'], 
				'phone'		 	  => $arrAddress['phone'], 
				'email'		 	  => $arrAddress['email'], 
				'items'			  => $arrOrderItems[$objOrders->id],
				'grandTotal'	=> $this->Isotope->formatPriceWithCurrency($objOrders->grandTotal),
			);			   
		}

		if (empty($arrExport))
		{
			return '<div id="tl_buttons">
					<a href="'.ampersand(str_replace('&key=export_order', '', $this->Environment->request)).'" class="header_back" title="'.specialchars($GLOBALS['TL_LANG']['MSC']['backBT']).'">'.$GLOBALS['TL_LANG']['MSC']['backBT'].'</a>
					</div>
					<p class="tl_gerror">'. $GLOBALS['TL_LANG']['MSC']['noOrders'] .'</p>';
		}

		header('Content-Type: application/csv');
		header('Content-Transfer-Encoding: binary');
		header('Content-Disposition: attachment; filename="isotope_order_export_' . $this->parseDate($GLOBALS['TL_CONFIG']['dateFormat'], time()) . '_' . $this->parseDate($GLOBALS['TL_CONFIG']['timeFormat'], time()) .'.csv"');
		header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
		header('Pragma: public');
		header('Expires: 0');

		$output = '';

		foreach ($arrExport as $export)
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
	public function exportItems()
	{		
		if ($this->Input->get('key') != 'export_items')
		{
			return '';
		}

		$arrExport = array();
		$arrExport[] = array(
			'order_id'		=> $GLOBALS['TL_LANG']['tl_iso_orders']['csv_head']['order_id'],	
			'date'			  => $GLOBALS['TL_LANG']['tl_iso_orders']['csv_head']['date'],	
			'lastname'	 	=> $GLOBALS['TL_LANG']['tl_iso_orders']['csv_head']['lastname'],	
			'firstname' 	=> $GLOBALS['TL_LANG']['tl_iso_orders']['csv_head']['firstname'],	
			'street'	 	  => $GLOBALS['TL_LANG']['tl_iso_orders']['csv_head']['street'],	
			'postal'	 	  => $GLOBALS['TL_LANG']['tl_iso_orders']['csv_head']['postal'],	
			'city'		 	  => $GLOBALS['TL_LANG']['tl_iso_orders']['csv_head']['city'],	
			'phone'		 	  => $GLOBALS['TL_LANG']['tl_iso_orders']['csv_head']['phone'],	
			'email'		 	  => $GLOBALS['TL_LANG']['tl_iso_orders']['csv_head']['email'],	
			'count'			  => $GLOBALS['TL_LANG']['tl_iso_orders']['csv_head']['count'],
			'item_name'		=> $GLOBALS['TL_LANG']['tl_iso_orders']['csv_head']['item_name'],
			'item_price'	=> $GLOBALS['TL_LANG']['tl_iso_orders']['csv_head']['item_price'],
			'sum'			    => $GLOBALS['TL_LANG']['tl_iso_orders']['csv_head']['sum'],
		);
		
		$objOrders = $this->Database->execute("SELECT * FROM tl_iso_orders ORDER BY order_id ASC");
		$objOrderItems = $this->Database->execute("SELECT * FROM tl_iso_order_items")->fetchAllAssoc();
		
		$arrOrderItems = array();
		foreach ( $objOrderItems as $items )
		{						
			$arrOrderItems[$items['pid']][] = array
			(
				'count'			  => $items['product_quantity'],
				'item_name'		=> html_entity_decode( $items['product_name'] ),
				'item_price'	=> $this->Isotope->formatPriceWithCurrency($items['price']),
				'sum'			    => $this->Isotope->formatPriceWithCurrency($items['product_quantity'] * $items['price']),		
			);		
		}

		while ($objOrders->next())
		{
			$arrAddress = deserialize($objOrders->billing_address);
	
			foreach ($arrOrderItems[$objOrders->id] as $item)
			{
				$arrExport[] = array(
					'order_id'		=> $objOrders->order_id,
					'date'			  => $this->parseDate($GLOBALS['TL_CONFIG']['datimFormat'], $objOrders->date),
					'lastname'	 	=> $arrAddress['lastname'], 
					'firstname' 	=> $arrAddress['firstname'],
					'street'	 	  => $arrAddress['street_1'], 
					'postal'	 	  => $arrAddress['postal'], 
					'city'		 	  => $arrAddress['city'], 
					'phone'		 	  => $arrAddress['phone'], 
					'email'		 	  => $arrAddress['email'], 
					'count'			  => $item['count'],
					'item_name'		=> $item['item_name'],
					'item_price'	=> $item['item_price'],
					'sum'			    => $item['sum'],
				);
			}			   
		}

		if (empty($arrExport))
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

		foreach ($arrExport as $export)
		{
			$output .= '"' . implode( "\";\"", $export ) . "\"\n";
		}

		echo $output;
		exit;
	}	
}		
		
		
		
