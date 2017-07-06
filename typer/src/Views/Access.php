<?php
namespace Views;

class Access extends View {

    private static $messages = array(
        'LOGIN_FAILED' => 'Niepoprawne dane logowania!',
        'FORM_DATA_MISSING' => 'Nie wypełniono wszystkich pól formularza',
        'SERVER_ERROR' => 'Bląd servera!',
        'ERROR' => 'Nieokreslony blad',
        'STATUS_FAILED' => 'Dane rejestracyjne nie zostały jeszcze potwierdzone'
    );

    //wyswietla formularz do logowania
    public function logform($result = null){
        if(isset($result)){
            if(array_key_exists($result, self::$messages))
                $this->set('message', self::$messages[$result]);
            else
                $this->set('message', self::$messages['SERVER_ERROR']);
        }
        $this->render('logform');
    }
}



