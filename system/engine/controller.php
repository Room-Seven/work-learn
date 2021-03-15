<?php
/**
 * @package		SITE
 * @author		Ron Tayler
 * @copyright	2020
*/

/**
 * Controller class
 *
 * Registry library
 * @property Document document
 * @property rtf rtf
 * @property Config config
 * @property Log err_log
 * @property Log debug_log
 * @property Event event
 * @property Loader load
 * @property Request request
 * @property Response response
 * @property DB db
 * @property Session session
 * @property Cache cache
 * @property Url url
 * @property Language language
 */
abstract class Controller {
	protected $registry;

	public function __construct($registry) {
		$this->registry = $registry;
	}

	public function __get($key) {
		return $this->registry->get($key);
	}

	public function __set($key, $value) {
		$this->registry->set($key, $value);
	}
}