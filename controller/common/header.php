<?php

/**
 * Class ControllerCommonHeader
 */
class ControllerCommonHeader extends controller{
    public function index(){
        //$this->document->addScript('/view/js/header.js','body');
        $this->document->addStyle('/view/css/header.css');

        $data = array();

        if($this->user->isLogged()){
            $data['isLogged'] = true;
            $data['user_name'] = $this->user->getUserName();
        }

        $this->document->setHeader($this->load->view('common/header',$data));
    }
}
