<?php
class Account
{
    private $connection;
    private $table_name = "account";

    public $id_account;
    public $account_number;
    public $balance;
    public $id_user;

    public function __construct($db){
        $this->connection = $db;
    }
    function readAll(){
        $query = "SELECT * FROM account";
        $stmt = $this->connection->prepare($query);
        $stmt->execute();
        return $stmt;
    }
    function read_idAccount($id)
    {
        // zapytanie wyswietlajace kontrahentow po NIP'ie
        $query = "SELECT * FROM account WHERE id_kontrahenta = '$id'";

        // wykonanie zapytania
        $stmt = $this->connection->prepare($query);

        // execute query
        $stmt->execute();

        return $stmt;
    }
    function readOne($id_account){
        $query = "SELECT * FROM account WHERE id_account = '$id_account'";
        $stmt = $this->connection->prepare($query);
        $stmt->execute();
        return $stmt;
    }
    function delete($id_account){
        $query = "Delete FROM account WHERE id_account = $id_account";
        $stmt = $this->connection->prepare($query);
        $stmt->execute();
        return $stmt;
    }
    function searchByAccountNumber($account_number){
        $query = "SELECT * FROM account WHERE account_number LIKE '%$account_number%' order by account_number";
        $stmt = $this->connection->prepare($query);
        $stmt->execute();
        return $stmt;
    }
    function searchByBalance($balance){
        $query = "SELECT * FROM account WHERE balance LIKE '%$balance%' order by balance";
        $stmt = $this->connection->prepare($query);
        $stmt->execute();
        return $stmt;
    }
    function searchById_user($id_user){
        $query = "SELECT * FROM account WHERE id_user LIKE '%$id_user%' order by id_user";
        $stmt = $this->connection->prepare($query);
        $stmt->execute();
        return $stmt;
    }
    function update($id_account, $account_number, $balance, $id_user){
        $query = "UPDATE account SET account_number = '$account_number', balance = '$balance', id_user = '$id_user'WHERE id_account = $id_account";
        $stmt = $this->connection->prepare($query);
        $stmt->execute();
        return $stmt;
    }
    function create($account_number, $balance, $id_user){
        $account_number = htmlspecialchars(strip_tags($account_number));
        $balance = htmlspecialchars(strip_tags($balance));
        $id_user = htmlspecialchars(strip_tags($id_user));
        $query = "INSERT INTO account
        (account_number, balance, id_user)
        VALUES ('$account_number', '$balance', '$id_user')";
        $stmt  = $this->connection->prepare($query);
        //$stmt->execute();
        if ($stmt->execute()) {
            return $stmt;
        }
        return false;
    }
}
