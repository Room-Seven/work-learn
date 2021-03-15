<?php
/**
 * @package		SITE
 * @author		Ron Tayler
 * @copyright	2020
 */

/**
 * Log class
 */
class Log {
	private $handle;
	private $registry;

    /**
     * Constructor
     * @param string $filename
     */
	public function __construct($filename) {

		$this->handle = fopen($filename, 'a');
		$this->write('new request: '.$_SERVER['HTTP_HOST'].'/'.$_GET['route'].'--------------');
	}
	
	/**
     * write
     * @param	string	$message
     */
	public function write($message) {
		fwrite($this->handle, date('Y-m-d G:i:s') . ' - ' . print_r($message, true) . "\n");
	}
	
	/**
     * Destructor
     */
	public function __destruct() {
		fclose($this->handle);
	}
}