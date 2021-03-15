<?php
/**
 * @package		SITE
 * @author		Ron Tayler
 * @copyright	2020
*/

/**
* Config class
*/
class Config {
	private $data = array();
    protected static $_inst;

	private function __construct(){}
    private function __clone(){}
    protected function __wakeup(){}

    /**
     * getInst
     * @return Config
     */
    public static function getInst() {
        if (self::$_inst === null) {
            self::$_inst = new self;
        }
        return self::$_inst;
    }

    /**
     * get
     * @param	string	$key
	 * @return	mixed
     */
	public function get($key) {
		return (isset($this->data[$key]) ? $this->data[$key] : null);
	}
	
    /**
     * set
     * @param	string	$key
	 * @param	string	$value
     */
	public function set($key, $value) {
		$this->data[$key] = $value;
	}

    /**
     * has
     * @param	string	$key
	 * @return	mixed
     */
	public function has($key) {
		return isset($this->data[$key]);
	}
	
    /**
     * load
     * @param	string	$file
     */
	public function load($file) {
		if (file_exists($file)) {
			$_ = array();
			require(modification($file));
			$this->data = array_merge($this->data, $_);
		} else {
			trigger_error('Error: Could not load config ' . $file . '!');
			exit();
		}
	}
}