<?php
/*
Plugin Name: WP World of Warcraft
Plugin URI: http://mymmoinc.com/wpplugin/wow/
Description: Display Random World of Warcraft Images on Your Wordpress Site.
Author: My MMO Shop
Version: 1.0
Author URI: http://mymmoshop.com/buy/world-of-warcraft-us/gold/index.php
*/

if (function_exists('add_action')) {
	// Initialize Plugin
	add_action('plugins_loaded', 'LoadWoW');
}

function LoadWoW() {
	global $objWPWoW;
	$objWPWoW = new WPWoW();

	// Install If Needed
	register_activation_hook(__FILE__,'WPWoWInstall');

	// Register Widget
	register_sidebar_widget('WP WoW', 'WPWoWSidebar');
}


class WPWoW {

	var $strService;
	var $strLastLoad;
	var $strCached;
	var $strResponse;

	function WPWoW() {
		if (function_exists('add_shortcode')) {
			add_shortcode('WPWoW', array(&$this, 'ShowImages'));
		}
	}
	
	function LoadOpts() {
		$this->strService = 'http://mymmoinc.com/wpplugin/wow/images/imagesrss.php';
		$this->strLastLoad = get_option('WPWoW_LastCache');
		$this->strCache = get_option('WPWoW_Cache');
	}
	
	function ShowImages($arrParams = '') {
		// PHP 5 XML Libraries Required
		if (!function_exists('simplexml_load_string')) {
			return false;
		}

		// Load Options at Runtime
		$this->LoadOpts();

		// Shortcode Params
		if (function_exists('shortcode_atts')) {
			extract(shortcode_atts(array('Count' => 5), $arrParams));
		}
		if (!$Count) {
			$Count = 5;
		}
		$this->strService .= '?Count=' . $Count;
		

		// Load from Cache
		$this->strResponse = $this->strCached;

		// Nothing Cached
		if (empty($this->strLastLoad) || empty($this->strCached)) {
			$this->LoadLive();
		}

		// Cache is Expired
		if (strtotime($this->strLastLoad) < strtotime('now -1day')) {
			$this->LoadLive();
		}

		if (empty($this->strResponse)) {
			return false;
		}
		
		$objXML = simplexml_load_string($this->strResponse);

		$objChannel = $objXML->channel;
		$strLink = $objChannel->link;

		$strOut = '';

		$intX = 0;
		foreach ($objChannel->item as $objThisItem) {

			$strThisTitle = $objThisItem->title;
			$strThisDesc = $objThisItem->description;
			$strThisDate = $objThisItem->pubDate;
			$strThisGUID = $objThisItem->guid;
			$strThisLink = $objThisItem->link;
			
			$strOut .= $strThisDesc;
			
			$intX++;
			if ($intX == $Count) {
				break;
			}
		}

		$strOut .= '</ul><p><small>Plugin by <a href="http://mymmoshop.com/buy/world-of-warcraft-us/gold/index.php">World of Warcraft Gold</a></small></p>';
		return $strOut;
	}

	function LoadLive() {
		$strResponse = $this->CurlIt();
		$strNow = date('Y-m-d h:i:sa');

		if ($strResponse) {
			$this->strResponse = $strResponse;
			$this->strLastLoad = $strNow;
			update_option('WPWoW_LastCache', $strNow);
			update_option('WPWoW_Cache', $strResponse);
		}
		else {
			$this->strResponse = '';
			$this->strLastLoad = '';
		}
	}

	function CurlIt() {
		if (!function_exists('curl_exec')) {
			return false;
		}
		$ch = curl_init();   
		curl_setopt($ch, CURLOPT_URL, $this->strService);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_VERBOSE, 1);

		$strResult = curl_exec($ch);
		
		curl_close($ch);
		
		return $strResult;
	}


}

function WPWoWInstall() {
	add_option('WPWoW_LastCache', '');
	add_option('WPWoW_Cache', '');
}

function WPWoWSidebar($arrParams) {
	extract($arrParams);
	echo $before_widget;
	echo $before_title;
	echo $after_title;
	WPWoW_ShowImages();
	echo $after_widget;

}

function WPWoW_ShowImages($intInCount = 5) {
	global $objWPWoW;
	echo $objWPWoW->ShowImages(array('Count' => $intInCount));
}

?>