<?php
/**
 * @package     Work-Learn
 * @author      Ron Tayler
 * @copyright   2020
 */

/**
 * Class ControllerStartupRoute
 * @author Ron Tayler
 * @todo Добавить проверку категории запроса: Get, Post, Ajax, Socket. Для автообновления страницы без полной перезагрузки
 */
class ControllerStartupRoute extends Controller
{
    /**
     * Функция обработки пути запроса и активации нужного контролера
     * @return object action
     */
    public function index()
    {
        if(isset($this->request->get['route']) && strlen($this->request->get['route'])>0){
            $route = $this->request->get['route'];
            $route = str_replace('-','_',$route);
            $route = str_replace('/[^a-zA-Z0-9_\/]/','',$route);
        }else{
            unset($this->request->get['route']);
            $route = $this->config->get('action_default');
        }
        return new action($route);
    }
}