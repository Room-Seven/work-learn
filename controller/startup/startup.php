<?php

class ControllerStartupStartup extends Controller{

    public function index(){

        // Если авотризация пройдена то загрузить Класс библиотеки User
        $this->user = new User($this->registry);

    }
}





