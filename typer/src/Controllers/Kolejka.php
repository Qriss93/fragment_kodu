<?php
/**
 * Created by PhpStorm.
 * User: Krzysiek
 * Date: 2016-12-01
 * Time: 17:20
 */

namespace Controllers;


class Kolejka extends Controller
{



    public function index(){

        $view = $this->getView('Kolejka');
        $view->index();
    }
    
    //dodanie  nowej kolejki
    public function insert(){
        
        $model = $this->getModel('Kolejka');
        $result=$model->insert();
        if($result === 0)
        {
            $this->redirect('Kolejka/');
        }
        else{
            $view = $this->getView('Kolejka');
            $view->index($result);
        }

    }
    

    //usuwanie kolejki
    public function delete($id=null){
        $model = $this->getModel('Kolejka');
        $view = $this->getView('Kolejka');
        if($id!==null)
        {
           if($model->checkStatus($id) < 1) {
               $model->delete($id);
               $this->redirect('Kolejka/');
           }
            else{
                $view->index('ERROR_STATUS');
            }
        }
        else{
            $this->redirect('Kolejka/');
        }


    }


    //uruchomienie kolejki
    public function run($id){


        if($id!==null)
        {
            $model=$this->getModel('Kolejka');
            if($model->checkStatus($id) == 0 && $model->getAllMecz($id) >= 10) {
                $model->changeStatus($id, 1);
            }
        }

        $this->redirect('Kolejka/');
    }


}

