<?php
/**
 * @package     Work-Learn
 * @author      Ron Tayler
 * @copyright   2020
 */

/**
 * Class ControllerCommonTask
 * @property ModelTask model_task
 */
class ControllerCommonTask extends Controller{

    public function add(){
        $data = array();
        $this->load->model('task');
        if(count($this->request->post)>0){
            $fv = $this->form_validate($this->request->post);
            if($fv===true){
                $this->model_task->addTask($this->request->post);
                if(isset($this->session->data['referer'])){
                    $url = $this->session->data['referer'];
                    unset($this->session->data['referer']);
                    $this->response->redirect($url);
                }else{
                    $this->response->redirect($this->url->link('home'));
                }
            }else{
                $data['error'] = 'Проверьте всё и попробуйте снова.';
            }
        }
        if(isset($this->request->server['HTTP_REFERER']))$this->session->data['referer'] = $this->request->server['HTTP_REFERER'];
        $this->document->setTitle('Добавить задание');
        $this->document->setKeywords('Новое задание, Создать задание, Добавить задание');

        $data['title'] = 'Новое задание';
        $data['referer'] = isset($this->request->server['HTTP_REFERER'])?$this->request->server['HTTP_REFERER']:'';
        $this->document->setContent($this->load->view('common/task_form',$data));
        return new Action('common/html');
    }

    public function edit(){
        $data = array();
        $this->load->model('task');
        if(count($this->request->post)>0){
            $fv = $this->form_validate($this->request->post);
            if($fv===true){
                $param = $this->request->post;
                $param['task-id'] = $this->request->get['task_id'];
                $this->model_task->editTask($param);
                if(isset($this->session->data['referer'])){
                    $url = $this->session->data['referer'];
                    unset($this->session->data['referer']);
                    $this->response->redirect($url);
                }else{
                    $this->response->redirect($this->url->link('home'));
                }
            }else{
                // TODO На всех страницах добавить единый масив ошибок и выводить их в одном месте
                $data['error'] = 'Проверьте всё и попробуйте снова.';
            }
        }
        if(isset($this->request->server['HTTP_REFERER']))$this->session->data['referer'] = $this->request->server['HTTP_REFERER'];
        if(isset($this->request->get['task_id'])){
            $task = $this->model_task->getTask((int)$this->request->get['task_id']);
            if($task){
                $this->document->setTitle('Редактировать задание');
                $this->document->setKeywords('Редактировать задание, Изменить задание, Отредактировать задание');

                $data['title'] = 'Редактировать задание';
                $data['task_id'] = $task['id'];
                $data['task_name'] = $task['user-name'];
                $data['task_email'] = $task['e-mail'];
                $data['task_text'] = $task['text'];
                $data['task_status'] = $task['status'];

                $data['referer'] = isset($this->request->server['HTTP_REFERER'])?$this->request->server['HTTP_REFERER']:'';

                $data['statuses'] = array();
                $statuses = $this->model_task->getTaskStatuses();
                foreach ($statuses as $status){
                    $status['select'] = ($task['status']==$status['id']);
                    $data['statuses'][] = $status;
                }

                $this->document->setContent($this->load->view('common/task_edit_form',$data));
                return new Action('common/html');
            }
        }
        // Else
        if(isset($this->session->data['referer'])){
            $url = $this->session->data['referer'];
            unset($this->session->data['referer']);
            $this->response->redirect($url);
        }else{
            $this->response->redirect($this->url->link('home'));
        }
    }

    private function form_validate($post){
        if( isset($post['name'])&&
            isset($post['e-mail'])&&
            isset($post['task-text'])
        ){
            if(!(strlen($post['name'])<100)){
                return 'name';
            }
            if(!(preg_match('/^([a-z0-9_-]+\.)*[a-z0-9_-]+@[a-z0-9_-]+(\.[a-z0-9_-]+)*\.[a-z]{2,}$/',$post['e-mail'])===1)){
                return 'e-mail';
            }
        }else{
            return false;
        }
        return true;
    }
}




