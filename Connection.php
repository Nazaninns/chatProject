<?php
class Connection{
    private PDO $pdo;
    private static ? Connection $instance=null;

    private function __construct(){
        $this->pdo = new PDO('mysql:host=localhost;dbname=hw14','root');
        $this->pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE,PDO::FETCH_ASSOC);
    }
    public static function getInstance(){
if (static::$instance==null) 
    static::$instance=new Connection();

    return static::$instance;

    }
public function getPdo(){
     return $this->pdo;
}



}

?>
