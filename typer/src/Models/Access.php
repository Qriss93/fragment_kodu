<?php
namespace Models;
use \PDO;
class Access extends Model {
    public function login($name, $password){
        //weryfikacja podanych danych logowania


        $login = $name;
        $pass = $password;

        try{
            $stmt = $this->pdo->prepare('SELECT uzytkownik.idUser, uzytkownik.login, uzytkownik.haslo, accessUser.idAccess
                                         FROM accessUser
                                         INNER JOIN uzytkownik ON uzytkownik.idUser = accessUser.idUser
                                         WHERE uzytkownik.login=:login');
            $stmt->bindValue(':login', $login, PDO::PARAM_STR);
            $stmt->execute();
            $result = $stmt->fetch();
            $stmt->closeCursor();
            if($result===false && empty($result)){
                return 'LOGIN_FAILED';
            }
        }
        catch(\PDOException $e) {

            return 'SERVER_ERROR';
        }
        //porownanie hasel z tym pobranym z bazy z tym od uzytkownka
        $pass_db = $result[2];
        if(crypt($pass, $pass_db) != $pass_db){

            return 'LOGIN_FAILED';
        }
        else{
            //zalogowanie i pzypisanie zmienym sesyjnym informacji o uzytkowniku(jego id i access)
            \Tools\Access::login($result[0], $result[3]);
            return 0;
        }

        

    }
    public function logout(){
        \Tools\Access::logout();
    }
}
