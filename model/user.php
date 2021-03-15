<?php
/**
 * @package     Work-Learn
 * @author      Ron Tayler
 * @copyright   2020
 */

/**
 * Class ModelUser
 * TODO Функции для работы с таблицами wl_user и wl_user_group
 */
class ModelUser extends Model{

    /**
     * getUserForId
     * @param $id
     * @return array|bool (Id,Login,E-mail,Status,Data-Add,Group-ID,Group-Name) or False
     */
    public function getUser4id($id){
        $sql = 'SELECT `u.id` as id,`u.user` as login,`u.e-mail` as \'e-mail\',`u.status` as status,`u.data-add` as \'data-add\',`u.user_group_id` as group-id,`g.name` as group-name FROM wl_user AS u JOIN wl_user_group AS g ON (u.group_user_id==g.id) WHERE u.id='.$id;
        $response = $this->db->query($sql);
        if($response->num_rows>0){
            return $response->row;
        }else{
            return false;
        }
    }

    /**
     * HasAuthUser Проверка авторизации
     * @param $login
     * @param $pass
     * @return int user_id
     */
    public function hasAuthUser($login,$pass){
        $sql = 'SELECT id, password FROM '.DB_PREFIX.'user WHERE `user` LIKE \''.$login.'\'';
        $response =  $this->db->query($sql);
        if($response->num_rows>0){
            $row = $response->row;
            if(password_verify($pass,$row['password'])){
                return $row['id'];
            }else{
                return false;
            }
        }else{
            return false;
        }
    }

    /**
     * AddUser
     * @param $param (Login,Password,E-mail,Group,Status)
     * @throws Exception Ошибка добавления
     */
    public function addUser($param){
        $login = $param['login'];
        $hash = password_hash($param['password'],PASSWORD_BCRYPT);
        $email = $param['email'];
        $group = $param['group'];
        $sql = 'INSERT INTO '.DB_PREFIX.'user (`user`, `password`, `e-mail`,`user_group_id`) VALUES (\''.$login.'\', \''.$hash.'\', \''.$email.'\', \''.$group.'\')';
        $this->db->query($sql);
    }

    /**
     * EditUser
     * @param $id int ID Пользователя
     * @param $param array (Login,Password,E-mail,Group,Status)
     * @return bool True or False
     * @throws Exception Ошибка редактирвоания
     * TODO Написать функцию
     */
    public function editUser($id,$param){

    }

    public function getGroup4id($id){
        $sql = 'SELECT * FROM '.DB_PREFIX.'user_group WHERE id='.$id;
        $response = $this->db->query($sql);
        if($response->num_rows>0){
            return $response->row;
        }else{
            return false;
        }
    }
    public function getGroup4name($name){
        $sql = 'SELECT * FROM '.DB_PREFIX.'user_group WHERE name LIKE \''.$name.'\'';
        $response = $this->db->query($sql);
        if($response->num_rows>0){
            return $response->row;
        }else{
            return false;
        }
    }

    public function hasPerm4GroupId($id,$route){
        $sql = 'SELECT * FROM '.DB_PREFIX.'user_group_perm WHERE user_group_id='.$id.' AND route LIKE \''.$route.'\' AND status=1';
        $response = $this->db->query($sql);
        if($response->num_rows>0){
            return true;
        }else{
            return false;
        }
    }
}





