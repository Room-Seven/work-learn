<?php
/**
 * @package     Work-Learn
 * @author      Ron Tayler
 * @copyright   2020
 */


class ControllerErrorNotFound  extends Controller{

    public function index(){
        //$this->language->load('');
        $this->document->setTitle('404');
        $this->document->setDescription('Not found');
        $this->document->setKeywords('Not found');
        $this->response->addHeader('HTTP/1.0 404 Not Found');
        $this->document->addStyle('view/css/not_found.css');


        $data = array();
        $this->document->setContent($this->load->view('error/not_found', $data));
        return new Action('common/html');
    }
}
