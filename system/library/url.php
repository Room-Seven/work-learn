<?php
/**
* @package		SITE
* @author		Ron Tayler
* @copyright	2020
*/

/**
* URL class
*/
class Url {
	private $url;
	private $ssl;
	private $rewrite = array();
	
	/**
	 * Constructor
	 * @param	string	$url
	 * @param	string	$ssl
	 *
 	 */
	public function __construct($url, $ssl = '') {
		$this->url = $url;
		$this->ssl = $ssl;
	}

	/**
	 * @param	object	$rewrite
 	 */
	public function addRewrite($rewrite) {
		$this->rewrite[] = $rewrite;
	}

	/**
	 * @param	string		$route
	 * @param	mixed		$args
	 * @param	bool		$secure
	 * @return	string
 	 */
	public function link($route, $args = '', $secure = false) {
		if ($this->ssl && $secure) {
			$url = $this->ssl . $route;
		} else {
			$url = $this->url . $route;
		}
		
		if ($args) {
			if (is_array($args)) {
				$url .= '?' . http_build_query($args);
			} else {
				$url .= str_replace('&', '&amp;', '?' . ltrim($args, '&'));
			}
		}
		
		foreach ($this->rewrite as $rewrite) {
			$url = $rewrite->rewrite($url);
		}
		
		return $url; 
	}
}