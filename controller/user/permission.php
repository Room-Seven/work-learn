<?php
/**
 * @package     Work-Learn
 * @author      Ron Tayler
 * @copyright   2020
 */

/**
 * Class ControllerUserPermission
 * @property User user
 * @property ModelRoute model_route
 */
class ControllerUserPermission extends Controller{

    public function index(){
        $this->load->model('route');
        $route = $this->model_route->getRoute4route($this->request->get['route']);
        if($route){
            switch ($route['permission_code']){
                case 'all':
                    return true;
                    break;
                case 'logged':
                    if($this->user->isLogged()){
                        if($this->user->hasPermission($this->request->get['route'])){
                            return true;
                        }else{
                            return new Action('error/forbidden');
                        }
                    }else{
                        $this->response->redirect($this->url->link('user/auth'));
                    }
                    break;
                case 'dev':
                    if($this->user->getGroupName() == 'developer'){
                        return true;
                    }else{
                        return new Action('error/404');
                    }
                    break;
                default:
                    $this->err_log->write('Pre-Action(\'user/permission\'): неверный permission_code');
                    return new Action('error/404');
            }
        }else{
            return new Action('error/404');
        }
    }
}