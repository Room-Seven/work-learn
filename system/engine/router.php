<?php
/**
 * @package		SITE
 * @author		Ron Tayler
 * @copyright	2020
*/

/**
 * Router class
 */
final class Router {
	private $registry;
	private $pre_action = array();
	private $error;

    /**
     * Constructor
     * @param $registry Registry
     */
	public function __construct($registry) {
		$this->registry = $registry;
	}
	
	/**
	 * @param	Action	$pre_action
 	 */
	public function addPreAction(Action $pre_action) {
		$this->pre_action[] = $pre_action;
	}

    /**
     * @param Action $action
     * @param Action $error
     * @throws ReflectionException
     */
	public function dispatch(Action $action, Action $error) {
		$this->error = $error;

		foreach ($this->pre_action as $pre_action) {
			$result = $this->execute($pre_action);

			if ($result instanceof Action) {
				$action = $result;

				break;
			}
		}

		while ($action instanceof Action) {
			$action = $this->execute($action);
		}
	}

    /**
     * @param Action $action
     * @return Action
     * @throws ReflectionException
     */
	private function execute(Action $action) {
		$result = $action->execute($this->registry);

		if ($result instanceof Action) {
			return $result;
		} 
		
		if ($result instanceof Exception) {
			$action = $this->error;
			
			$this->error = null;
			
			return $action;
		}
	}
}