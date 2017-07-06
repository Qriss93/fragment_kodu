<?php

namespace Config\Database;
use \PDO;

class DBConfig {
    private static $type;
    private static $host;
    private static $port;
    private static $user;
    private static $pass;
    private static $database;

    public static function setDBConfig($database ='inz', $user='root', $pass='',
                                       $host='localhost', $type='mysql', $port='3306'){
        DBConfig::$database = $database;
        DBConfig::$user = $user;
        DBConfig::$pass = $pass;
        DBConfig::$host = $host;
        DBConfig::$type = $type;
        DBConfig::$port = $port;
    }

    //połączenei z bazą danych 
    public static function getHandle(){
        try{
            $pdo = new PDO(DBConfig::$type.':host='.DBConfig::$host.';dbname='.DBConfig::$database.';port='.DBConfig::$port, DBConfig::$user, DBConfig::$pass);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $pdo;
        }
        catch(\PDOException $e){
            echo 'Blad polaczenia z baza danych!';
            exit(1);
        }
    }
}
