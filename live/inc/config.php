<?php
class dbConfig {
    protected $serverName;
    protected $userName;
    protected $password;
    protected $dbName;
    function dbConfig() {
        $this -> serverName = 'localhost:3307';
        $this -> userName = 'root';
        $this -> password = 'web@ptli';
        $this -> dbName = 'sol';
    }
}
?>