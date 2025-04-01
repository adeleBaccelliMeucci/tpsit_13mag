<?php

// SINGLETON
class Db extends MySQLi{
    static protected $instance = null; //importante

    public function __construct($host, $user, $password, $schema){
        parent::__construct($host, $user, $password, $schema);
    }

    static function getInstance(){  //importante
        if(self::$instance == null){ //la prima volta
            self::$instance = new Db('my_mariadb', 'root', 'ciccio', 'scuola');
        }
        return self::$instance;
    }

    public function select($table, $where = 1){
        $query = "SELECT * FROM $table WHERE $where";
        if($result = $this->query($query)){
            return $result->fetch_all(MYSQLI_ASSOC);
        }
        return [];
    }
}