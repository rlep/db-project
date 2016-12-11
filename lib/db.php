<?php
use Symfony\Component\Yaml\Yaml;

class Db {
    private static $connection = null;

    public static function get_db_connection() {
        return self::$connection;
    }

    public static function dbc() {
        return self::get_db_connection();
    }

    public static function connect($testing=false) {
        $config = Yaml::parse(file_get_contents("config/db.yaml"));
        $o = $testing ? $config["test"] : $config["app"];
        
        self::$connection = new PDO('mysql:host='.$o["server"].';dbname='.$o["db"].';charset=utf8', $o["username"], $o["password"]);
        self::$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public static function init_db($with_fixtures=false) {
        
    }

    public static function flush_db() {

    }
}
