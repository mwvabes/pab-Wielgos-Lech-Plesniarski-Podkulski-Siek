<?php
session_start();
class Operation{
    private $connection;
    private $table_name = "operation";

    public $id_operation;
    public $id_account;
    public $title;
    public $amount;
    public $type;
    public $sender_number;
    public $sender_name;
    public $sender_address;
    public $recipent_number;
    public $recipent_name;
    public $recipent_address;
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
    function readOneAccountOperations($id_account){
        $query = "SELECT * FROM operation WHERE id_account = '$id_account'";
        $stmt = $this->connection->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    function readBeforePayment($id_account){
        $query = "SELECT * FROM operation inner join account on operation.id_account=account.id_account WHERE operation.id_account = '$id_account'";
        $stmt = $this->connection->prepare($query);
        $stmt->execute();
        return $stmt;
    }


    function getAccountNumber($odzial){
        $first=$odzial;
        $first1 = substr($first, 2, 2);
        $first2 = substr($first, 4, 24);
        $first=$first2."2521".$first1;
        $first1 = substr($first, 0, 6);
        $first1 = $first1 % 97;
        $first1 = $first1 . substr($first, 6, 4);
        $first1 = (int)$first1 % 97;
        $first1 = $first1 . substr($first, 10, 4);
        $first1 = (int)$first1 % 97;
        $first1 = $first1 . substr($first, 14, 4);
        $first1 = (int)$first1 % 97;
        $first1 = $first1 . substr($first, 18, 4);
        $first1 = (int)$first1 % 97;
        $first1 = $first1 . substr($first, 22, 4);
        $first1 = (int)$first1 % 97;
        $first1 = $first1 . substr($first, 26, 4);
        $check = (int)$first1%97;
        if($check==1){
            return 1;

        }else{
            return 0;
        }

    }
    function getTypeOfSend($odzial){
        $first=$odzial;
        $first1 = substr($first, 4, 3);
        if($first1==105){
            return 1;

        }else{
            return 0;
        }

    }


    function doPayment($id_account,$account_number,$balance,$amount,$title,$recipent_number,$recipent_name,$recipent_address,$sender_name,$sender_address,$type_payment){
            if($balance>$amount){ // check if user have enough cash to pay
                $check=$this->getAccountNumber($recipent_number);
                if($check==1){ //check if recipent number is valid
                    $check1=$this->getTypeOfSend($recipent_number); //check if payment is to in or out
                    if($check1==1){
                        $check2=$this->recipent_number;
                        $query = "SELECT * FROM account where account_number='$recipent_number'";
                        $stmt = $this->connection->prepare($query);
                        $stmt->execute();
                        $num  = $stmt->rowCount();
                        if($num!=0){

                            $query="INSERT INTO `operation` (`id_account`,`title`,`amount`,`type`, `sender_number`,`sender_name`,`sender_address`,`recipent_number`,`recipent_name`,`recipent_address`,`status`,`date`) VALUES ('$id_account','$title','$amount','$type_payment','$account_number','$sender_name', '$sender_address',  '$recipent_number','$recipent_name', '$recipent_address', 'completed', NOW())";
                            $stmt = $this->connection->prepare($query);
                            $stmt->execute();

                            $query = "UPDATE account SET balance = (balance-'$amount') WHERE account_number = '$account_number'";
                            $stmt = $this->connection->prepare($query);
                            $stmt->execute();

                            $query = "UPDATE account SET balance = (balance+'$amount') WHERE account_number = '$recipent_number'";
                            $stmt = $this->connection->prepare($query);
                            $stmt->execute();

                            $query ="Select id_account from account where account_number='$recipent_number'";
                            $stmt = $this->connection->prepare($query);
                            $stmt->execute();

                            $SingleVar = $stmt->fetchColumn();
                            $query="INSERT INTO `operation` (`id_account`,`title`,`amount`,`type`, `sender_number`,`sender_name`,`sender_address`,`recipent_number`,`recipent_name`,`recipent_address`,`status`,`date`) VALUES  ('$SingleVar','$title','$amount','$type_payment','$account_number','$sender_name', '$sender_address',  '$recipent_number','$recipent_name', '$recipent_address',  'received', NOW())";
                            $stmt = $this->connection->prepare($query);
                            $stmt->execute();
                            if($stmt){
                                $_SESSION['fails_payment']="Payment accepted and finalized.";
                            }
                            return 1;

                        }else{
                            $_SESSION['fails_payment']="No Recipient with this account number.Try again.";
                            return 0;
                        }

                        return 1;
                    }else{
                        if($type_payment=='normal'){
                            //take token
                            $url_download_token = 'https://jr-api-express.herokuapp.com/api/auth/login';
                            $data_download_token = array('username' => 'b105', 'password' => 'operator6');
                            $token=$this->getToken($url_download_token,$data_download_token);
                            $result = json_decode($token,true);
                            $token=$result['token'];
                            //take token

                            //send normal payment
                            $url_send_normal_payment = 'https://jr-api-express.herokuapp.com/api/payment';
                            $data_send_normal_payment = array(
                                'senderAccountnumber' => $account_number,
                                'senderName' => $sender_name,
                                'senderAddress' => $sender_address,
                                'recipientAccountnumber' => $recipent_number,
                                'recipientName' => $recipent_name,
                                'recipientAddress' => $recipent_address,
                                'paymentTitle' => $title,
                                'paymentAmount' => $amount,
                                'currency' => 'PLN',
                            );

                            $result_payment=$this->getAcceptedPayment($url_send_normal_payment,$token,$data_send_normal_payment);
                            $result_payment =json_decode($result_payment,true);
                            $isPayment=$result_payment['isPaymentAccepted'];
                            $isPayment2=$result_payment['message'];
                            if($isPayment==1){
                                $_SESSION['fails_payment']='Payment accepted. Send to recipient and realization is started.';
                                //save payment inside bank
                                $query="INSERT INTO `operation` (`id_account`,`title`,`amount`,`type`, `sender_number`,`sender_name`,`sender_address`,`recipent_number`,`recipent_name`,`recipent_address`,`status`,`date`) VALUES ('$id_account','$title','$amount','$type_payment','$account_number','$sender_name', '$sender_address',  '$recipent_number','$recipent_name', '$recipent_address', 'sended', NOW())";
                                $stmt = $this->connection->prepare($query);
                                $stmt->execute();

                                $query = "UPDATE account SET balance = (balance-'$amount') WHERE account_number = '$account_number'";
                                $stmt = $this->connection->prepare($query);
                                $stmt->execute();

                                //save payment inside bank
                            }else{
                                $_SESSION['fails_payment']='Payment not accepted. '.$isPayment2;
                                //save payment inside bank
                                $query="INSERT INTO `operation` (`id_account`,`title`,`amount`,`type`, `sender_number`,`sender_name`,`sender_address`,`recipent_number`,`recipent_name`,`recipent_address`,`status`,`date`) VALUES ('$id_account','$title','$amount','$type_payment','$account_number','$sender_name', '$sender_address',  '$recipent_number','$recipent_name', '$recipent_address', 'failed', NOW())";
                                $stmt = $this->connection->prepare($query);
                                $stmt->execute();
                                //save payment inside bank

                            }

                            //send normal payment

                            return 0;
                        }else{
                            $_SESSION['fails_payment']="Express Payment accepted and realized.";
                            $amount2= $amount+2.5;

   /* user's acc  */        $query="INSERT INTO `operation` (`id_account`,`title`,`amount`,`type`, `sender_number`,`sender_name`,`sender_address`,`recipent_number`,`recipent_name`,`recipent_address`,`status`,`date`) VALUES ('$id_account','$title','$amount2','$type_payment','$account_number','$sender_name', '$sender_address',  '$recipent_number','$recipent_name', '$recipent_address', 'sended', NOW())";
                            $stmt = $this->connection->prepare($query);
                            $stmt->execute();

                            $query = "UPDATE account SET balance = (balance-'$amount2') WHERE account_number = '$account_number'";
                            $stmt = $this->connection->prepare($query);
                            $stmt->execute();

                            $query = "UPDATE account SET balance = (balance+'$amount2') WHERE account_number = 'PL98105044755588264284882898'";
                            $stmt = $this->connection->prepare($query);
                            $stmt->execute();

                            $query ="Select id_account from account where account_number='PL98105044755588264284882898'";
                            $stmt = $this->connection->prepare($query);
                            $stmt->execute();
                            $SingleVar = $stmt->fetchColumn();

/*banks's expres acc */     $query="INSERT INTO `operation` (`id_account`,`title`,`amount`,`type`, `sender_number`,`sender_name`,`sender_address`,`recipent_number`,`recipent_name`,`recipent_address`,`status`,`date`) VALUES  ('$SingleVar','express: $account_number -> $recipent_number','$amount2','$type_payment','$account_number','$sender_name', '$sender_address',  'PL98105044755588264284882898','bank express account', 'Rzeszow 14a',  'received', NOW())";
                            $stmt = $this->connection->prepare($query);
                            $stmt->execute();

                            $query = "UPDATE account SET balance = (balance-'$amount') WHERE account_number = 'PL98105044755588264284882898'";
                            $stmt = $this->connection->prepare($query);
                            $stmt->execute();



                            // send to unit of account
                            $url_download_token = 'https://jr-api-express.herokuapp.com/api/auth/login';
                            $data_download_token = array('username' => 'b105', 'password' => 'operator6');
                            $token=$this->getToken($url_download_token,$data_download_token);
                            $result = json_decode($token,true);
                            $token=$result['token'];
                            //take token

                            //send normal payment
                            $url_send_normal_payment = 'https://jr-api-express.herokuapp.com/api/payment';
                            $data_send_normal_payment = array(
                                'senderAccountnumber' => $account_number,
                                'senderName' => $sender_name,
                                'senderAddress' => $sender_address,
                                'recipientAccountnumber' => $recipent_number,
                                'recipientName' => $recipent_name,
                                'recipientAddress' => $recipent_address,
                                'paymentTitle' => $title,
                                'paymentAmount' => $amount,
                                'currency' => 'PLN',
                            );

                            $result_payment=$this->getAcceptedPayment($url_send_normal_payment,$token,$data_send_normal_payment);
                            $result_payment =json_decode($result_payment,true);
                            $isPayment=$result_payment['isPaymentAccepted'];
                            // send to unit of account
                            //$isPayment2=$result_payment['message'];
                            // send to bank a with express payment
                            $url_download_token = 'https://jr-api-express.herokuapp.com/api/auth/login';
                            $data_download_token = array('username' => 'b105', 'password' => 'operator6');
                            $token=$this->getToken($url_download_token,$data_download_token);
                            $result = json_decode($token,true);
                            $token=$result['token'];
                            //take token
                            //send normal payment
                            $url_send_normal_payment = 'https://localhost:8080/Bank_A/dejlli/create';
                            $data_send_normal_payment = array(
                                'senderAccountnumber' => $account_number,
                                'senderName' => $sender_name,
                                'senderAddress' => $sender_address,
                                'recipientAccountnumber' => $recipent_number,
                                'recipientName' => $recipent_name,
                                'recipientAddress' => $recipent_address,
                                'paymentTitle' => $title,
                                'paymentAmount' => $amount,
                                'currency' => 'PLN',
                            );

                            $result_payment=$this->getAcceptedPayment($url_send_normal_payment,$token,$data_send_normal_payment);
                            $result_payment =json_decode($result_payment,true);
                            $isPaymentExpress=$result_payment['isPaymentAccepted'];
                            // send to bank a with express payment
                            //$isPayment2=$result_payment['message'];
                            if($isPaymentExpress==false){

                                $query = "UPDATE account SET balance = (balance+'$amount') WHERE account_number = '$account_number'";
                                $stmt = $this->connection->prepare($query);
                                $stmt->execute();

                                $query = "UPDATE account SET balance = (balance-'$amount') WHERE account_number = 'PL98105044755588264284882898'";
                                $stmt = $this->connection->prepare($query);
                                $stmt->execute();

                                $query="INSERT INTO `operation` (`id_account`,`title`,`amount`,`type`, `sender_number`,`sender_name`,`sender_address`,`recipent_number`,`recipent_name`,`recipent_address`,`status`,`date`) VALUES  ('$id_account','express: PaymentBack $account_number -> $recipent_number','$amount','$type_payment','PL98105044755588264284882898','bank express account', 'Rzeszow 14a',  '$account_number','$sender_name', '$sender_address',  'received', NOW())";
                                $stmt = $this->connection->prepare($query);
                                $stmt->execute();
                            }
                            return 1;
                        }

                        return 0;
                    }

                }else{
                    $_SESSION['fails_payment']="Wrong account number. Try again later.";
                    return 0;
                }
            }else{
                    $_SESSION['fails_payment']="No enough cash on your account.";
                    return 0;
            }


    }

    function doPaymentBack($sender_number,$sender_name,$sender_address,$recipent_number,$recipent_name,$recipent_address,$title,$amount){
                        $query ="Select id_account from account where account_number='PL98105044751144856531642383'";
                        $stmt = $this->connection->prepare($query);
                        $stmt->execute();
                        $SingleVar = $stmt->fetchColumn();
                        $query="INSERT INTO `operation` (`id_account`,`title`,`amount`,`type`, `sender_number`,`sender_name`,`sender_address`,`recipent_number`,`recipent_name`,`recipent_address`,`status`,`date`) VALUES ('$SingleVar','Not found a number: $recipent_number','$amount','save cash on bank payback acoount','$sender_number','$sender_name','$sender_address','PL98105044751144856531642383','Bank B Payback',  'Rzeszow 10a', 'gained', NOW())";
                        $stmt = $this->connection->prepare($query);
                        $stmt->execute();
                        $query = "UPDATE account SET balance = (balance+'$amount') WHERE account_number = 'PL98105044751144856531642383'";
                        $stmt = $this->connection->prepare($query);
                        $stmt->execute();
                        //take token
                        $url_download_token = 'https://jr-api-express.herokuapp.com/api/auth/login';
                        $data_download_token = array('username' => 'b105', 'password' => 'operator6');
                        $token=$this->getToken($url_download_token,$data_download_token);
                        $result = json_decode($token,true);
                        $token=$result['token'];
                        //take token
                        //send normal payment
                        $url_send_normal_payment = 'https://jr-api-express.herokuapp.com/api/payment';
                        $data_send_normal_payment = array(
                            'senderAccountnumber' => 'PL98105044751144856531642383',
                            'senderName' => 'Bank_B_Payback',
                            'senderAddress' => 'Bank_B_address',
                            'recipientAccountnumber' => $sender_number,
                            'recipientName' => $sender_name,
                            'recipientAddress' => $sender_address,
                            'paymentTitle' => 'Payback_for_no_account_number_'.$recipent_number,
                            'paymentAmount' => $amount,
                            'currency' => 'PLN',
                        );
                        $result_payment=$this->getAcceptedPayment($url_send_normal_payment,$token,$data_send_normal_payment);
                        $result_payment =json_decode($result_payment,true);
                        $isPayment=$result_payment['isPaymentAccepted'];
                        $isPayment2=$result_payment['message'];
                        if($isPayment==1){
                            $_SESSION['fails_payment']='Payment accepted. Send to recipient and realization.';
                            //save payment inside bank
                            $query="INSERT INTO `operation` (`id_account`,`title`,`amount`,`type`, `sender_number`,`sender_name`,`sender_address`,`recipent_number`,`recipent_name`,`recipent_address`,`status`,`date`) VALUES ('$SingleVar','PayBack for  $recipent_number','$amount','normal Payback','PL98105044751144856531642383','$recipent_name Bank B Payback', '$recipent_address Bank B Payback',  '$sender_number','$sender_name', '$sender_address', 'sended', NOW())";
                            $stmt = $this->connection->prepare($query);
                            $stmt->execute();

                            $query = "UPDATE account SET balance = (balance-'$amount') WHERE account_number = 'PL98105044751144856531642383'";
                            $stmt = $this->connection->prepare($query);
                            $stmt->execute();
                            if($stmt){
                                $_SESSION['fails_payment']='Payment accepted. Send to recipient and realization.';
                            }else{
                                $_SESSION['fails_payment']='Payment sad. Send to recipient and realization.';
                            }
                            //save payment inside bank
                        }else{

                            //save payment inside bank
                            $query="INSERT INTO `operation` (`id_account`,`title`,`amount`,`type`, `sender_number`,`sender_name`,`sender_address`,`recipent_number`,`recipent_name`,`recipent_address`,`status`,`date`) VALUES ('$SingleVar','payback $recipent_number','$amount','normal Payback','PL98105044751144856531642383','$recipent_name Bank B Payback', '$recipent_address Bank B Payback',  '$sender_number','$sender_name', '$sender_address', 'declined', NOW())";                            $stmt = $this->connection->prepare($query);
                            $stmt->execute();
                        }
    }
    function getPaymentList(){
        $url = 'https://jr-api-express.herokuapp.com/api/auth/login';
        $url1 = 'https://jr-api-express.herokuapp.com/api/payment/getIncoming/?bankCode=105';
        $data = array('username' => 'b105', 'password' => 'operator6');
        $take_token=httpPost($url,$data);
        $result = json_decode($take_token,true);
        $token=$result['token'];
        $response=httpPost1($url1,$token);
        return $response;
    }


    function update($id_operation,$title,$amount,$type,$sender_number,$sender_name,$sender_address,$recipent_number, $recipent_name,$recipent_address,$status,$date){
        $query = "UPDATE operation SET title = '$title',amount = '$amount',$type = '$type',sender_number = '$sender_number',sender_name = '$sender_name',sender_address = '$sender_address',recipent_number = '$recipent_number' , recipent_name = '$recipent_name' , recipent_address = '$recipent_address' , status = '$status' ,date = '$date'  WHERE id_operation = $id_operation";
        $stmt = $this->connection->prepare($query);
        $stmt->execute();

        return $stmt;
    }

    function create($id_account,$title,$amount,$type,$sender_number,$sender_name,$sender_address,$recipent_number, $recipent_name,$recipent_address,$status,$date){
        $title = htmlspecialchars(strip_tags($title));
        $amount = htmlspecialchars(strip_tags($amount));
        $type = htmlspecialchars(strip_tags($type));
        $sender_number = htmlspecialchars(strip_tags($sender_number));
        $sender_name = htmlspecialchars(strip_tags($sender_name));
        $sender_address = htmlspecialchars(strip_tags($sender_address));
        $recipent_number = htmlspecialchars(strip_tags($recipent_number));
        $recipent_name = htmlspecialchars(strip_tags($recipent_name));
        $recipent_address = htmlspecialchars(strip_tags($recipent_address));
        $status = htmlspecialchars(strip_tags($status));
        $date = htmlspecialchars(strip_tags($date));
        $query = "INSERT INTO operation
        (id_account, title, amount, type, sender_number,sender_name,sender_address,recipent_number,recipent_name,recipent_address,status,date)
        
        VALUES ('$id_account', '$title', '$amount', '$type', '$sender_number','$sender_name','$sender_address','$recipent_number','$recipent_name','$recipent_address', '$status', NOW())";
        $stmt  = $this->connection->prepare($query);
        //$stmt->execute();
        if ($stmt->execute()) {
            return $stmt;
        }
    }


    function getToken($url,$data){
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($data));
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($curl);
        curl_close($curl);
        return $response;
    }
    function getAcceptedPayment($url2,$token,$data)
    {
        $curl = curl_init($url2);
        curl_setopt($curl, CURLOPT_POST, true);

        curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($data));
        curl_setopt($curl, CURLOPT_HEADER, 0); // set to 0 to eliminate header info from response

        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array(
            'Authorization: ' . $token,
            'Content-Type: application/x-www-form-urlencoded',
        ));
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

        $response = curl_exec($curl);
        curl_close($curl);
        return $response;
    }


}


?>

