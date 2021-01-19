<?php
class Operation{
    private $connection;
    private $table_name = "operation";

    public $id_operation;
    public $id_account;
    public $title;
    public $amount;
    public $type;
    public $sender_number;
    public $recipent_number;
    public $status;
    public $date;

    public function __construct($db){
        $this->connection = $db;
    }
    function readAll(){
        $query = "SELECT * FROM operation";
        $stmt = $this->connection->prepare($query);
        $stmt->execute();
        return $stmt;
    }
    function readOne($id_operation){
        $query = "SELECT * FROM operation WHERE id_operation = '$id_operation'";
        $stmt = $this->connection->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    function searchId_account($id_account){
        $query = "SELECT * FROM operation WHERE id_account = '$id_account'";
        $stmt = $this->connection->prepare($query);
        $stmt->execute();
        return $stmt;
    }
    function searchTitle($title){
        $query = "SELECT * FROM operation WHERE title = '$title'";
        $stmt = $this->connection->prepare($query);
        $stmt->execute();
        return $stmt;
    }
    function searchAmount($amount){
        $query = "SELECT * FROM operation WHERE amount = '$amount'";
        $stmt = $this->connection->prepare($query);
        $stmt->execute();
        return $stmt;
    }
    function searchType($type){
        $query = "SELECT * FROM operation WHERE type = '$type'";
        $stmt = $this->connection->prepare($query);
        $stmt->execute();
        return $stmt;
    }
    function searchSender_number($sender_number){
        $query = "SELECT * FROM operation WHERE sender_number = '$sender_number'";
        $stmt = $this->connection->prepare($query);
        $stmt->execute();
        return $stmt;
    }
    function searchRecipent_number($recipent_number){
        $query = "SELECT * FROM operation WHERE recipent_number = '$recipent_number'";
        $stmt = $this->connection->prepare($query);
        $stmt->execute();
        return $stmt;
    }
    function searchStatus($status){
        $query = "SELECT * FROM operation WHERE status = '$status'";
        $stmt = $this->connection->prepare($query);
        $stmt->execute();
        return $stmt;
    }
    function searchDate($date){
        $query = "SELECT * FROM operation WHERE date = '$date'";
        $stmt = $this->connection->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    function update($id_operation,$title,$amount,$type, $sender_number, $recipent_number, $status, $date){
        $query = "UPDATE operation SET title = '$title', amount = '$amount', $type = '$type', sender_number = '$sender_number',recipent_number = '$recipent_number' , status = '$status' ,date = '$date'  WHERE id_operation = $id_operation";
        $stmt = $this->connection->prepare($query);
        $stmt->execute();

        return $stmt;
    }
    function create($id_account,$title,$amount,$type, $sender_number, $recipent_number, $status, $date){
        $title = htmlspecialchars(strip_tags($title));
        $amount = htmlspecialchars(strip_tags($amount));
        $type = htmlspecialchars(strip_tags($type));
        $sender_number = htmlspecialchars(strip_tags($sender_number));
        $recipent_number = htmlspecialchars(strip_tags($recipent_number));
        $status = htmlspecialchars(strip_tags($status));
        $date = htmlspecialchars(strip_tags($date));
        $query = "INSERT INTO osoba_kontaktowa
        (id_account, title, amount, type, sender_number,recipent_number,status,date)
        VALUES ('$id_account', '$title', '$amount', ' $type', '$sender_number', '$recipent_number', '$status', '$date')";
        $stmt  = $this->connection->prepare($query);
        //$stmt->execute();
        if ($stmt->execute()) {
            return $stmt;
        }
    }
}
