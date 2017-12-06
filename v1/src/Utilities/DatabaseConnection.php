<?php
/**
 * Created by PhpStorm.
 * User: lilipeng
 * Date: 12/5/17
 * Time: 23:41
 */



class DatabaseConnection
{
    private static $instance = null;
    private static $host = "localhost";
    private static $dbname = "W01254326";
    private static $user = "w01254326";
    private static $pass = "Lilics!";

    private function __construct()
    {

    }

    public static function getInstance()
    {
        if (!static::$instance === null) {
            return static::$instance;
        } else {
            try {
                $connectionString = "mysql:host=".static::$host.";dbname=".static::$dbname;
                static::$instance = new \PDO($connectionString, static::$user, static::$pass);
                static::$instance->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
                return static::$instance;
            } catch (PDOException $e) {
                echo "Unable to connect to the database: " . $e->getMessage();
                die();
            }
        }
    }
}