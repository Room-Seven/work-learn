<?php
/**
 * @package		SITE
 * @author		Ron Tayler
 * @copyright	2020
 */

/**
 * Event class
 */
class Event {
	protected $registry;
	protected $data = array();

    /**
     * Constructor
     * @param $registry Object Registry
     */
	public function __construct($registry) {
		$this->registry = $registry;
	}
	
	/**
	 * @param	$trigger    String
	 * @param	$action     Action
	 * @param	$priority   Int
 	*/	
	public function register($trigger, Action $action, $priority = 0) {
		$this->data[] = array(
			'trigger'  => $trigger,
			'action'   => $action,
			'priority' => $priority
		);
		
		$sort_order = array();

		foreach ($this->data as $key => $value) {
			$sort_order[$key] = $value['priority'];
		}

		array_multisort($sort_order, SORT_ASC, $this->data);	
	}
	
	/**
	 * @param	string	$event
	 * @param	array	$args
 	 */
	public function trigger($event, array $args = array()) {
		foreach ($this->data as $value) {
			if (preg_match('/^' . str_replace(array('\*', '\?'), array('.*', '.'), preg_quote($value['trigger'], '/')) . '/', $event)) {
				$result = $value['action']->execute($this->registry, $args);

				if (!is_null($result) && !($result instanceof Exception)) {
					return $result;
				}
			}
		}
	}
	
	/**
	 * @param	string	$trigger
	 * @param	string	$route
 	 */
	public function unregister($trigger, $route) {
		foreach ($this->data as $key => $value) {
			if ($trigger == $value['trigger'] && $value['action']->getId() == $route) {
				unset($this->data[$key]);
			}
		}			
	}
	
	/**
	 * @param	string	$trigger
 	 */
	public function clear($trigger) {
		foreach ($this->data as $key => $value) {
			if ($trigger == $value['trigger']) {
				unset($this->data[$key]);
			}
		}
	}	
}