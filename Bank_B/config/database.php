<?php
class Database{
    private $host = "localhost";
    private $database_name = "bankb";
    private $username = "root";
    private $password = "";
    public $connection;

    public function getConnection(){
        $this->connection = null;
        try{
            $this->connection = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->database_name, $this->username, $this->password);
            $this->connection->exec("set names utf8");
        }catch(PDOException $exception){
            echo "Błąd łączenia: " . $exception->getMessage();
        }
        return $this->connection;
    }
}
?>
