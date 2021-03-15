<?php


class ControllerErrorForbidden  extends Controller{

    public function index(){
        //$this->language->load('');
        $this->document->setTitle('403');
        $this->document->setDescription('Forbidden');
        $this->document->setKeywords('Forbidden');
        $this->response->addHeader('HTTP/1.0 403 Not Found');
        $this->document->addStyle('view/css/not_found.css');


        $data = array();
        $this->document->setContent($this->load->view('error/forbidden', $data));
        return new Action('common/html');
    }
}
