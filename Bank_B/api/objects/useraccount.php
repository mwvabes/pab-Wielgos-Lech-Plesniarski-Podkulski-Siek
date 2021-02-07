<?php
class UserAccount{
    private $connection;
    public $id;
    public $firstname;
    public $lastname;
    public $pesel;
    public $email;
    public $telephone;
    public $address;
    public $username;
    public $password;
    public $type_user;
    public $id_account;
    public $account_number;
    public $balance;
    public $id_user;

    public function __construct($db){
        $this->connection=$db;
    }
    function readEverythingAccounts(){
        $query = "SELECT * FROM user inner join account on user.id=account.id_user";
        $stmt = $this->connection->prepare($query);
        $stmt->execute();
        return $stmt;
    }
    function readEverythingAccountsOne($id_user){
        $query = "SELECT * FROM user inner join account on user.id=account.id_user where id_user='$id_user' LIMIT 1";
        $stmt = $this->connection->prepare($query);
        $stmt->execute();
        return $stmt;
    }


}

?>

