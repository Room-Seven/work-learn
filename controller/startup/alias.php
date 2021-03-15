<?php

/**
 * Class ControllerUserAlias
 * @package SITE
 * @author Ron Tayler
 */
class ControllerStartupAlias extends controller{

    /**
     * pre-action startup/alias
     */
    public function index(){
        if(isset($this->request->get['route']) && strlen($this->request->get['route'])>0){
            $route = $this->request->get['route'];
            $route = str_replace('/[^a-zA-Z0-9_\-\/]/','',$route);
            $sql = 'SELECT route FROM '.DB_PREFIX.'alias WHERE alias=\''.$route.'\'';
            $r = $this->db->query($sql);
            if($r->num_rows > 0){
                $route = $r->row['route'];
            }
            $this->request->get['route'] = $route;
        }else{
            $this->request->get['route'] = $this->config->get('action_default');
        }
    }
}




