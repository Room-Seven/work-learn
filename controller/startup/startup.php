<?php
/**
 * @package     Work-Learn
 * @author      Ron Tayler
 * @copyright   2020
 */

class ControllerStartupStartup extends Controller{

    public function index(){

        // Если авотризация пройдена то загрузить Класс библиотеки User
        $this->user = new User($this->registry);

    }
}





