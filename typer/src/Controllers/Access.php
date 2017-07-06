<?php
namespace Controllers;

class Access extends Controller {

    public function logform($result = null){
        $view=$this->getView('Access');
        $view->logform($result);
    }
    
    public function login(){
        $model=$this->getModel('Access');
        if(!$_POST['login'] || !$_POST['password'])
            $this->logform('FORM_DATA_MISSING');
        else {
            $result = $model->login($_POST['login'], ($_POST['password']));
            if ($result === 0)
                $this->redirect('');
            else
                $this->logform($result);
        }
    }

    //wylogowuje z systemu
    public function logout(){
        $model=$this->getModel('Access');
        $model->logout();
        $this->redirect('');
    }
}
