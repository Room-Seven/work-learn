<?php
/**
 * @package		SITE
 * @author		Ron Tayler
 * @copyright	2020
 */

/**
 * Registry class
 */
final class Registry {
	private $data = array();

	/**
     * @param	string	$key
	 * @return	mixed
     */
	public function get($key) {
		return $this->data[$key] ?? null;
	}

    /**
     * @param	string	$key
	 * @param	string	$value
     */	
	public function set($key, $value) {
		$this->data[$key] = $value;
	}
	
    /**
     * @param	string	$key
	 * @return	bool
     */
	public function has($key) {
		return isset($this->data[$key]);
	}
}