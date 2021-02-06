<?php
class PaymentEndpoint{
    private $connection;

    public $id_operation;
  public $id_account;
  public $title;
  public $type;
  public $amount;
  public $sender_number;
  public $sender_name;
  public $sender_address;
  public $recipent_number;
  public $recipent_name;
  public $recipent_address;
  public $status;
  public $date;


    public function __construct($db){
        $this->connection=$db;
    }

// $senderAccount,$senderName,$senderAddress,$recipientAccountNumber,$recipientName,$recipientAddress,$paymentTitle,$paymentAmount,$currency
    function doPayment2($senderAccountnumber,$senderName,$senderAddress,$recipientAccountnumber,$recipientName,$recipientAddress,$paymentTitle,$paymentAmount){
        $query = "Select id_account from account where account_number='$recipientAccountnumber'";
        $stmt = $this->connection->prepare($query);
        $stmt->execute();
        $SingleVar=$stmt->fetchColumn();
        $query = "Select id_account from account where account_number='PL98105044758332285663955814'";
        $stmt = $this->connection->prepare($query);
        $stmt->execute();
        $SingleVar2=$stmt->fetchColumn();

        if($SingleVar!=0){
            $query="INSERT INTO `operation` (`id_account`,`title`,`amount`,`type`,`sender_number`,`sender_name`,`sender_address`,`recipent_number`,`recipent_name`,`recipent_address`,`status`,`date`) VALUES ('$SingleVar2', 'geting from express payment','$paymentAmount','express output','$senderAccountnumber', '$senderName', '$senderAddress',  'PL98105044758332285663955814','Bank B express account', 'Rzeszow 10a', 'accepted', NOW())";
            $stmt = $this->connection->prepare($query);
            $stmt->execute();
            $query="INSERT INTO `operation` (`id_account`,`title`,`amount`,`type`, `sender_number`,`sender_name`,`sender_address`,`recipent_number`,`recipent_name`,`recipent_address`,`status`,`date`) VALUES ('$SingleVar2','From express account to $recipientAccountnumber ','$paymentAmount','send to user','PL98105044758332285663955814','Bank B express account', 'Rzeszow 10a','$recipientAccountnumber','$recipientName', '$recipientAddress', 'sended', NOW())";
            $stmt = $this->connection->prepare($query);
            $stmt->execute();
            $query="INSERT INTO `operation` (`id_account`,`title`,`amount`,`type`, `sender_number`,`sender_name`,`sender_address`,`recipent_number`,`recipent_name`,`recipent_address`,`status`,`date`) VALUES ('$SingleVar','$paymentTitle','$paymentAmount','express payment','$senderAccountnumber','$senderName', '$senderAddress','$recipientAccountnumber','$recipientName', '$recipientAddress', 'accepted', NOW())";
            $stmt = $this->connection->prepare($query);
            $stmt->execute();
            $query = "UPDATE account SET balance = (balance+'$paymentTitle') WHERE account_number = 'PL98105044758332285663955814'";
            $stmt = $this->connection->prepare($query);
            $stmt->execute();
            $query = "UPDATE account SET balance = (balance-'$paymentTitle') WHERE account_number = 'PL98105044758332285663955814'";
            $stmt = $this->connection->prepare($query);
            $stmt->execute();
            $query = "UPDATE account SET balance = (balance-'$paymentTitle') WHERE account_number = '$recipientAccountnumber'";
            $stmt = $this->connection->prepare($query);
            $stmt->execute();
            $query = "Select  * from `operation` order by id_operation desc limit 1 ";
            $swiete = $this->connection->prepare($query);
            $swiete->execute();
            return $swiete;
        }

        return -1;

    }
}

?>