<?php
namespace Tools;

class Access extends Session {
    private static $login = 'user';
    private static $access = 'access';
    private static $loginTime = 'logintime';
    private static $sessionTime = 60;

    //zaloguj
    public static function login($idUser, $access) {
        //sprawdzenie istniejacej sesji
        if(parent::check() === true)
        {
            //zmieniajac poziom dostepu regenrerujemy sesje
            parent::regenerate();
            parent::set(self::$login, $idUser);
            parent::set(self::$access, $access);
            parent::set(self::$loginTime, time());
        }
    }
    //wyloguj
    public static function logout() {
        parent::clear(self::$login);
        parent::clear(self::$loginTime);
        parent::clear(self::$access);
        parent::regenerate();
    }
    //sprawdz czy jest zalogowany
    public static function islogin() {
        if(parent::is(self::$login) === true) {

            if(time() > parent::get(self::$loginTime) + self::$sessionTime) {
                //przekroczono czas sesji, wyloguj
                self::logout();
                return false;
            }
            parent::set(self::$loginTime, time());
            return true;
        }
        return false;
    }
}