<?php
session_start();
function httpPost($url,$data){
    $curl = curl_init($url);
    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($data));
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($curl);
    curl_close($curl);
    return $response;
}
function httpPost1($url1,$token)
{
    $curl = curl_init($url1);
    curl_setopt($curl, CURLOPT_HTTPHEADER, array(
        'Authorization: ' . $token,
    ));
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($curl);
    curl_close($curl);
    return $response;
}

function getPaymentList(){
    $url = 'https://jr-api-express.herokuapp.com/api/auth/login';
    $url1 = 'https://jr-api-express.herokuapp.com/api/payment/getIncoming/?bankCode=105';
    $data = array('username' => 'b105', 'password' => 'operator6');

    $curl = curl_init($url);
    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($data));
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    $get_token = curl_exec($curl);
    curl_close($curl);
    $result = json_decode($get_token,true);
    $token=$result['token'];

    $curl = curl_init($url1);
    curl_setopt($curl, CURLOPT_HTTPHEADER, array(
        'Authorization: ' . $token,
    ));
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($curl);
    curl_close($curl);
    return $response;

}

 $result = getPaymentList();

            if($result)
            {
                $arr = json_decode($result);
                foreach ($arr->r as $key => $value) {
                   $number1=$value->senderAccountnumber;
                   $number=$value->recipientAccountnumber;
                   $number2=$value->paymentTitle;
                   $number3=$value->paymentAmount;
                   $number4=$value->paymentStatus;
                   $number2=rawurlencode($number);
                   $type="normal";
                   $senderName="normal";
                   $senderAddress="normal";
                   $recipientName="normal";
                   $recipientAddress="normal";
                   $date="cos";

                    $json1 = @file_get_contents("http://localhost/bankB/api/constructor/readaccount.php?readOneAccountByNumber=&account_number=".$number);
                    if($json1){
                        $arr = json_decode($json1);
                        foreach ($arr->Accounts as $key => $value) {
                            $id_account = $value->id_account;
                        }
                        echo $number;
                        echo $number1;
                        echo $number2;
                        echo $number3;
                        echo $number4;
                        echo $type;
                        echo $senderName;
                        echo $senderAddress;
                        echo $recipientName;
                        echo $recipientAddress."<br/>";
                        $id_user1=1;
                        $id_user2=2;
                        $id_user3=3;

                        $json2 = @file_get_contents("http://localhost/bankB/api/constructor/readoperation.php?create=&id_account=".$id_account."&title=".$number2."&amount=".$number3."&type_payment=".$type."&sender_number=".$number1."&sender_name=".$senderName."&sender_address=".$senderAddress."&recipent_number=".$number."&recipent_name=".$recipientName."&recipent_address=".$recipientAddress."&status=".$number4."&date=".$date);
                       // $json2 = file_get_contents("http://localhost/bankB/api/constructor/readaccount.php?create=&account_number=".$id_user2."&balance=".$id_user3."&id_user=".$id_user1."");
                        if($json2){
                         echo "sucess";
                        }else{echo "failed";}



                    }else{
                        echo "Nie  znaleziono numeru konta.";
                    }

                }
            }
            else
            {
                echo "Nie znaleziono rekordów.";
            }







?>

