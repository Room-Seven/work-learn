<?php

/**
 *
 * set in __construct()
 * @property log err_log
 * @property session session
 * @property request request
 */
class User {
	private $user_id;
	private $user_group_id;
	private $user_group_name;
	private $username;
	private $permission = array();

	public function __construct($registry) {
		$this->db = $registry->get('db');
		$this->request = $registry->get('request');
		$this->session = $registry->get('session');
		$this->err_log = $registry->get('err_log');

		if (isset($this->session->data['user_id'])) {
		    $sql = 'SELECT * FROM '.DB_PREFIX.'user WHERE id = \''.(int)$this->session->data['user_id'].'\' AND status = \'1\'';
			$user_query = $this->db->query($sql);

			if ($user_query->num_rows>0) {
				$this->user_id = $user_query->row['id'];
				$this->username = $user_query->row['user'];
				$this->user_group_id = $user_query->row['user_group_id'];

				$sql = 'UPDATE '.DB_PREFIX.'user SET ip = \''.$this->db->escape($this->request->server['REMOTE_ADDR']).'\' WHERE id = \''.(int)$this->session->data['user_id'].'\'';
				$this->db->query($sql);

                $sql = 'SELECT * FROM `wl_user_group` WHERE id='.$this->user_group_id;
                $user_group_query = $this->db->query($sql);
                if($user_group_query->num_rows=0){
                    $this->err_log->write('Library/User/login() Запрос '.$sql.' Вернул пустой результат');
                    return false;
                }
                $this->user_group_name = $user_group_query->row['name'];

                $sql = 'SELECT r.route route FROM '.DB_PREFIX.'permission p LEFT JOIN wl_route r ON (p.route_id = r.id) WHERE p.user_group_id = '.$this->user_group_id.' AND p.status = 1';
                $permission_query = $this->db->query($sql);
                foreach($permission_query->rows as $row){
                    $this->permission[] = $row['route'];
                }
			} else {
				$this->logout();
			}
		}
	}

	public function login($username, $password) {
	    $sql = 'SELECT * FROM '. DB_PREFIX .'user WHERE user = \''.$this->db->escape($username).'\' AND status = 1';
		$user_query = $this->db->query($sql);

		if ($user_query->num_rows>0 && password_verify($password,$user_query->row['password'])) {
			$this->session->data['user_id'] = $user_query->row['id'];

			$this->user_id = $user_query->row['user_id'];
			$this->username = $user_query->row['user'];
			$this->user_group_id = $user_query->row['user_group_id'];

			$sql = 'SELECT * FROM `wl_user_group` WHERE id='.$this->user_group_id;
			$user_group_query = $this->db->query($sql);
			if($user_group_query->num_rows=0){
			    $this->err_log->write('Library/User/login() Запрос '.$sql.' Вернул пустой результат');
			    return false;
            }
			$this->user_group_name = $user_group_query->row['name'];

			$sql = 'SELECT r.route route FROM '.DB_PREFIX.'permission p LEFT JOIN wl_route r ON (p.route_id = r.id) WHERE p.user_group_id = '.$this->user_group_id.' AND p.status = 1';
			$permission_query = $this->db->query($sql);
			foreach($permission_query->rows as $row){
			    $this->permission[] = $row['route'];
            }

			return true;
		} else {
			return false;
		}
	}

	public function logout() {
		unset($this->session->data['user_id']);

		// Обнуление данных
		$this->user_id = '';
		$this->username = '';
		$this->user_group_id = 0;
        $this->user_group_name = '';
        $this->permission = array();
	}

	public function hasPermission($route) {
	    if (in_array($route,$this->permission)) {
			return true;
		} else {
			return false;
		}
	}

	public function isLogged() {
		return (isset($this->user_id) && ($this->user_id!=0));
	}

	public function getId() {
		return $this->user_id;
	}

	public function getUserName() {
		return $this->username;
	}

	public function getGroupId() {
		return $this->user_group_id;
	}

    public function getGroupName() {
        return $this->user_group_name;
    }
}