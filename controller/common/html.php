<?php
/**
 * @package     Work-Learn
 * @author      Ron Tayler
 * @copyright   2020
 */

/**
 * Class ControllerCommonHtml
 */
class ControllerCommonHtml extends controller {

    public function index(){
        if($this->config->get('template_jquery')){
            $this->document->addScript('/view/jquery/jquery-3.5.0.min.js');
            $this->document->addScript('https://code.jquery.com/jquery-migrate-3.0.0.min.js');
        }
        $this->document->addStyle('/view/css/html.css');

        //Load Header and Footer
        $this->load->controller('common/header');
        $this->load->controller('common/footer');

        $data = array();
        $data['template_bootstrap'] = $this->config->get('template_bootstrap');
        $data['base'] = HTTPS_SERVER;
        $data['title'] = 'Work-Learn | '.$this->document->getTitle();
        $data['description'] = $this->document->getDescription();
        $data['keywords'] = $this->document->getKeywords();
        $data['links'] = $this->document->getLinks();
        $data['styles'] = $this->document->getStyles();
        $data['js_head'] = $this->document->getScripts();
        $data['js_body'] = $this->document->getScripts('body');
        $data['js_code_head'] = $this->document->getScriptsCode();
        $data['js_code_body'] = $this->document->getScriptsCode('body');

        // Мета теги
        $data['meta_tags'] = array();
        $tags = $this->document->getMetaTags();
        foreach($tags as $tag){
            $params = array();
            foreach ($tag as $key => $param){
                $params[] = $key.'="'.$param.'"';
            }
            $data['meta_tags'][] = implode($params,' ');
        }

        $data['header'] = $this->document->getHeader();
        $data['content'] = $this->document->getContent();
        $data['footer'] = $this->document->getFooter();

        $this->response->setOutput($this->load->view('common/html',$data));
    }

}