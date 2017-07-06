<?php

namespace Models;
use \PDO;

abstract Class Model
{
    protected $pdo;

    public function __construct()
    {
        try {
            $this->pdo = \Config\Database\DBConfig::getHandle();
        } catch (\PDO\DBException $e) {
            echo 'Polaczenie z baza nie powidolo sie: ' . $e->getMessage();
        }
    }
}