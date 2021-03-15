<?php

class ControllerCommonFooter extends Controller{

    public function index(){
        $this->document->addStyle('view/css/footer.css');
        $this->document->setFooter($this->load->view('common/footer'));

    }
}
