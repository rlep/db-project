<?php
use Symfony\Component\Yaml\Yaml;

class Db {
    private static $connection;

    public static function get_db_connection() {
        return $connection;
    }

    public static function dbc() {
        return get_db_connection();
    }

    public static function connect($testing=false) {
        $config = Yaml::parse(file_get_contents("config/db.yaml"));
        print_r($config);
        $o = $testing ? $config["test"] : $config["app"];
        
        $connection = new PDO('mysql:host='.$o["server"].';dbname='.$o["db"].';charset=utf8', $o["username"], $o["password"]);
        
    }

    public static function init_db($with_fixtures=false) {
        
    }

    public static function flush_db() {

    }
}
