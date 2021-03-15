<?php
/**
 * @package     Work-Learn
 * @author      Ron Tayler
 * @copyright   2020
 */

/**
 * ControllerCommonHome
 *
 * Use in index()
 * @property ModelTask model_task
 * @property  pagination pagination
 */
class ControllerCommonHome extends Controller{

    public function index(){
        /** @property ModelTask model_task */
        $this->load->model('task');
        $this->load->library('pagination');

        $this->document->setTitle('Главная');
        $this->document->setDescription('Web приложение для организации задачь и их выполнения.');
        $this->document->setKeywords('Задачи, Поручения, Время, Учёт, ');
        $this->document->addStyle('/view/css/home.css');
        $this->document->addScriptCode('$(\'.time-tooltip\').tooltip({placement:\'right\',offset:\'0,5\'});','body');
        $this->document->addScriptCode('$(\'.task__icon>*\').tooltip({placement:\'bottom\',offset:\'0,5\'});','body');

        $data = array();

        $page = (isset($this->request->get['page']))?$this->request->get['page']:1;
        $task_limit = $this->config->get('limit_task_for_page');
        $param = array(
            'limit'=>[($page-1)*$task_limit,$task_limit],
            'status_delete'=>'0'
        );
        if(isset($this->request->get['sort']) && isset($this->request->get['order'])){
            $param['sort'] = $this->request->get['sort'];
            $param['order'] = $this->request->get['order'];
        }

        if(isset($this->request->get['sort'])&&$this->request->get['sort']=='user-name'&&$this->request->get['order']=='ASC'){
            $data['sort_user_href'] = $this->url->link('home',array('sort'=>'user-name','order'=>'DESC'));
            $data['isSortUserASC'] = true;
        }else{
            $data['sort_user_href'] = $this->url->link('home',array('sort'=>'user-name','order'=>'ASC'));
        }
        if(isset($this->request->get['sort'])&&$this->request->get['sort']=='user-name'&&$this->request->get['order']=='DESC'){
            $data['isSortUserDESC'] = true;
        }

        if(isset($this->request->get['sort'])&&$this->request->get['sort']=='e-mail'&&$this->request->get['order']=='ASC'){
            $data['sort_email_href'] = $this->url->link('home',array('sort'=>'e-mail','order'=>'DESC'));
            $data['isSortEmailASC'] = true;
        }else{
            $data['sort_email_href'] = $this->url->link('home',array('sort'=>'e-mail','order'=>'ASC'));
        }
        if(isset($this->request->get['sort'])&&$this->request->get['sort']=='e-mail'&&$this->request->get['order']=='DESC'){
            $data['isSortEmailDESC'] = true;
        }

        if(isset($this->request->get['sort'])&&$this->request->get['sort']=='status'&&$this->request->get['order']=='ASC'){
            $data['sort_status_href'] = $this->url->link('home',array('sort'=>'status','order'=>'DESC'));
            $data['isSortStatusASC'] = true;
        }else{
            $data['sort_status_href'] = $this->url->link('home',array('sort'=>'status','order'=>'ASC'));
        }
        if(isset($this->request->get['sort'])&&$this->request->get['sort']=='status'&&$this->request->get['order']=='DESC'){
            $data['isSortStatusDESC'] = true;
        }

        $tasks = $this->model_task->getTasks($param)->rows;
        foreach($tasks as $key=>$row){
            $status = $this->model_task->getTaskStatus($row['status']);
            $tasks[$key]['status-icon'] = $status['icon'];
            $tasks[$key]['status-title'] = $status['comment'];
            $tasks[$key]['isEdit'] = $this->user->hasPermission('common/task/edit');
            $tasks[$key]['time'] = $this->rtf->time_last(strtotime($row['data-add']),strtotime(date('Y-m-d G:i:s')));
            $tasks[$key]['time-tooltip'] = date('d.m.Y в G:i',strtotime($row['data-add']));
        }
        $data['tasks']=$tasks;

        $param = array('status_delete'=>'0');
        $this->pagination->total = $this->model_task->getCount($param);
        $this->pagination->limit = $task_limit;
        $this->pagination->page = $page;
        if(isset($this->request->get['sort']) && isset($this->request->get['order'])){
            $this->pagination->url = $this->url->link('home',array('page'=>'{page}','sort'=>$this->request->get['sort'],'order'=>$this->request->get['order']));
        }else{
            $this->pagination->url = $this->url->link('home','page={page}');
        }
        $data['pagination'] = $this->pagination->render();
        $this->document->setContent($this->load->view('common/home',$data));

        return new Action('common/html');
    }
}