<?php

namespace App\Lib;

use PDO;
use PDOException;
use Exception;

class Conexao
{
    private static $connection = null;

    public function __construct(){}

    public static function getConnection()
    {
        $pdoConfig = DB_DRIVER . ":host=" . DB_HOST . ";dbname=" . DB_NAME;

        try {
            
            if(self::$connection === null){
                self::$connection = new PDO($pdoConfig, DB_USER, DB_PASS,
                                            array(
                                                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                                                PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'
                                            ));               
            }
            
            return self::$connection;
            
        } catch (PDOException $ex) {
            throw new Exception("Erro de conexão com o banco de dados: " . $ex->getMessage(), 500);
        }
    }

}