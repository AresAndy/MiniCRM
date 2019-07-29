<?php

namespace MiniCRM\Sys;

class DB {
    private static $instance;
    private $conn;

    private $host = 'localhost';
    private $user = 'minicrm';
    private $pass = 'minicrm'; // fairly unsafe, will do for just proof of concept
    private $name = 'MiniCRM_DB';
    
    private function __construct($local = false) {
        if($local){
            $reflection = new \ReflectionClass(\Composer\Autoload\ClassLoader::class);
            $prjdir = dirname($reflection->getFileName(), 3);

            $path = "{$prjdir}/MiniCRM_DB.sqlite3";
            if(!is_file($path)){
                throw new Exception("File $path does not exist");
            }

            $this->conn = new \PDO("sqlite:{$path}");
        } else {
            $this->conn = new \PDO(
                "mysql:host={$this->host};dbname={$this->name}", 
                $this->user,$this->pass,
                array(\PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'")
            );
        }

        $this->conn->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
    }

    public static function init($local = false) : DB {
        if(!self::$instance) {
            self::$instance = new DB($local);
        }
        
        return self::$instance;
    }

    public function conn(): \PDO {
        return $this->conn;
    }
}