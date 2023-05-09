<?php

require_once __DIR__ . '/../Config/Config.php';

class Database
{
    public static function CreateDatabaseConnexion() : PDO
    {
        return new PDO
        (
            'mysql:host=' . DBHOST . ';dbname=' . DBNAME . ';charset=utf8',
            DBLOGIN,
            DBPASSWORD
        );
    }
}

?>