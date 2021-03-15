<?php
/**
 * @package     Work-Learn
 * @author      Ron Tayler
 * @copyright   2020
 */

class ModelRoute extends Model{

    public function getRoute4route($route){
        $sql = 'SELECT * FROM '.DB_PREFIX.'route WHERE route=\''.$route.'\'';
        $route_query = $this->db->query($sql);
        if($route_query->num_rows>0){
            return $route_query->row;
        }else{
            return false;
        }
    }
}