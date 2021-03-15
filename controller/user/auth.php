<?php

/**
 * Class ControllerUserAuth
 * @property ModelUser model_user
 */
class ControllerUserAuth extends Controller{

    /**
     * route = user/auth
     * Авторизация пользователя
     */
    public function index(){
        $data = array();
        if(count($this->request->post)>0){
            $fv = $this->form_validate($this->request->post);
            if($fv===true){
                $logged = $this->user->login($this->request->post['login'],$this->request->post['password']);
                if($logged){
                    //$token = token(64);
                    //$this->session->data['token'] = $token;TODO использование Token для безопастности
                    //setcookie('token',$token,true);
                    if(isset($this->session->data['referer'])){
                        $url = $this->session->data['referer'];
                        unset($this->session->data['referer']);
                        $this->response->redirect($url);
                    }else{
                        $this->response->redirect($this->url->link('home'));
                    }
                }else{
                    $data['error'] = 'логин или пароль не верные.';
                }
            }else{
                // TODO Добавить вывод ошибок из form_validate
                $data['error'] = 'Что-то введенно не так...';
            }
        }
        $this->document->setTitle('Авторизация');
        $this->document->setDescription('Вход в систему для администратора');
        $this->document->setKeywords('Не индексировать тут!☺');
        if(isset($this->request->server['HTTP_REFERER']))$this->session->data['referer'] = $this->request->server['HTTP_REFERER'];

        $this->document->setContent($this->load->view('user/auth_form',$data));
        return new Action('common/html');
    }

    public function logout(){
        $this->user->logout();
        $this->response->redirect($this->url->link('home'));
    }

    public function addUser(){
        $content = '';
        $error = false;
        if(!$this->request->get['login']){$content .= '<p>Отсутсвует login</p>';$error=true;}
        if(!$this->request->get['password']){$content .= '<p>Отсутсвует password</p>';$error=true;}
        if(!$this->request->get['email']){$content .= '<p>Отсутсвует email</p>';$error=true;}
        if(!$this->request->get['group']){$content .= '<p>Отсутсвует group</p>';$error=true;}
        if($error){
            $this->document->setContent($content);
            return new Action('common/html');
        }else{
            $this->load->model('user');
            $param = array(
                'login'=>$this->request->get['login'],
                'password'=>$this->request->get['password'],
                'email'=>$this->request->get['email'],
                'group'=>$this->request->get['group']
            );
            $this->model_user->addUser($param);
            $this->response->redirect($this->url->link('home'));
        }
    }

    private function form_validate($post){
        if( isset($post['login'])&&
            isset($post['password'])
        ){
            if(!(strlen($post['login'])<100)){
                return 'login';
            }
            if(!(preg_match('/^[a-zA-Z0-9,.()*+_\-]{3,32}$/',$post['password'])===1)){
                return 'password';
            }
        }else{
            return false;
        }
        return true;
    }
}





