<?php
/**
 * Created by PhpStorm.
 * User: Krzysiek
 * Date: 2016-12-01
 * Time: 23:42
 */

namespace Views;


class Kolejka extends View
{
    private static $messages = array(
        'SERVER_ERROR' => 'Bląd servera!',
        'ERROR_STATUS' => 'Można usunąć tylko kolejki które posiadają status (nie uruchomione)',
        'ERROR' => 'Przed dodniem kolejki należy stworzyć sezon'
    );

     //wyswietlenie widoku z lista kolejek
    public function index($result=null){

        $model=$this->getModel('Kolejka');
        $this->set('allKolejka', $model->getAll());
        if(isset($result)){
                $this->set('message', self::$messages[$result]);
        }
        $this->render('showKolejka');
    }

    
}