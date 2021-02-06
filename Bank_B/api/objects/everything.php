<?php
class Everything{
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
    public $id_operation;
    public $title;
    public $amount;
    public $type;
    public $sender_number;
    public $recipent_number;
    public $status;
    public $date;

    public function __construct($db){
        $this->connection=$db;
    }
    function readEverythingAccounts(){
        $query = "SELECT * FROM user inner join account on user.id=account.id_user inner join operation on account.id_account=operation.id_account";
        $stmt = $this->connection->prepare($query);
        $stmt->execute();
        return $stmt;
    }

}

?>

