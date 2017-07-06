<?php
namespace Controllers;
abstract class Controller {

    //przekierowanie na inny adres 
    public function redirect($url) {
        header('location: '.'http://'.$_SERVER["SERVER_NAME"].':8080'.'/'.
            \Config\Website\Config::$subdir.$url);
    }

    //pobranie modelu
    public function getModel($name){
        $name = 'Models\\'.$name;
        return new $name();
    }

    //zaladowanie widoku
    public function getView($name){
        $name = 'Views\\'.$name;
        return new $name();
    }
}