<?php

class ModelTask extends Model{

    /**
     * GetTasks - Выдать все задачи по параметрам сортировки
     * @param $param
     * TODO Добавить параметры сортировки
     * @return array
     */
    public function getTasks($param=array()){
        $sql  = 'SELECT * FROM '.DB_PREFIX.'task';
        $where_param = array();
        if(isset($param['status'])){
            if(preg_match('/^!([0-9]+)$/',$param['status'],$matches)){
                $where_param[] = ' not status='.$matches[1];
            }
            if(preg_match('/^([0-9]+)$/',$param['status'],$matches)){
                $where_param[] = ' status='.$matches[1];
            }
        }
        if(isset($param['status_delete'])){
            $where_param[] = 'status_delete='.$param['status_delete'];
        }
        if(count($where_param)>0){
            $sql .= ' WHERE '.implode(' AND ',$where_param);
        }
        if(
            isset($param['sort']) &&
            isset($param['order']) &&
            in_array($param['sort'],['user-name','e-mail','status']) &&
            in_array($param['order'],['ASC','DESC'])
        ){
            $sql .= ' ORDER BY binary(`'.$param['sort'].'`) '.$param['order'];
        }
        if(isset($param['limit'])) {
            $sql .= ' LIMIT ' . $param['limit'][0] . ',' . $param['limit'][1];
        }
        return $this->db->query($sql);
    }

    public function getCount($param=array()){
        $sql  = 'SELECT COUNT(*) as \'count\' FROM '.DB_PREFIX.'task';
        $where_param = array();
        if(isset($param['status'])){
            if(preg_match('/^!([0-9]+)$/',$param['status'],$matches)){
                $where_param[] = ' not status='.$matches[1];
            }
            if(preg_match('/^([0-9]+)$/',$param['status'],$matches)){
                $where_param[] = ' status='.$matches[1];
            }
        }
        if(isset($param['status_delete'])){
            $where_param[] = 'status_delete='.$param['status_delete'];
        }
        if(count($where_param)>0){
            $sql .= ' WHERE '.implode(' AND ',$where_param);
        }
        if(isset($param['limit'])){
            $sql .= ' LIMIT ' . $param['limit'][0] . ',' . $param['limit'][1];
        }
        return $this->db->query($sql)->row['count'];
    }

    public function getTask($id){
        $sql = 'SELECT * FROM '.DB_PREFIX.'task WHERE id='.$id;
        $task_query = $this->db->query($sql);
        if($task_query->num_rows>0){
            return $task_query->row;
        }else{
            return false;
        }
    }

    public function addTask($param = array()){
        $sql = 'INSERT INTO '.DB_PREFIX.'task (`user-name`, `e-mail`, `text`) VALUES (\''.$param['name'].'\', \''.$param['e-mail'].'\', \''.$param['task-text'].'\')';
        $this->db->query($sql);
    }

    public function editTask($param = array()){
        $sql = 'UPDATE '.DB_PREFIX.'task SET `user-name`=\''.$param['name'].'\', `e-mail`=\''.$param['e-mail'].'\', `text`=\''.$param['task-text'].'\',`status`=\''.$param['task-status'].'\' WHERE id='.$param['task-id'];
        $this->db->query($sql);
    }

    public function getTaskStatus($status_id){
        $sql = 'SELECT * FROM '.DB_PREFIX.'task_status WHERE id='.(int)$status_id;
        $status_query = $this->db->query($sql);
        if($status_query->num_rows>0){
            return $status_query->row;
        }else{
            return false;
        }
    }

    public function getTaskStatuses(){
        $sql = 'SELECT * FROM '.DB_PREFIX.'task_status';
        $status_query = $this->db->query($sql);
        if($status_query->num_rows>0){
            return $status_query->rows;
        }else{
            return false;
        }
    }
}



