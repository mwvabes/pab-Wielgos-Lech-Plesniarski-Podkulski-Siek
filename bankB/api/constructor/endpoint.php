<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
include_once '../objects/endpoint.php';
include_once '../../config/database.php';
$database=new Database();
$db=$database->getConnection();

$paymentEndPoint=new PaymentEndpoint($db);
if(isset($_GET['endPoint'])) {
    $stmtpaymentEndpoint = $paymentEndPoint->doPayment2($_GET['senderAccountnumber'], $_GET['senderName'], $_GET['senderAddress'], $_GET['recipientAccountnumber'], $_GET['recipientName'], $_GET['recipientAddress'], $_GET['paymentTitle'], $_GET['paymentAmount']);

    $num  = $stmtpaymentEndpoint->rowCount();
// sprawdzanie czy znaleziono wiecej niz 0 rekordow
}else{
    // ustawienie kodu odpowiedzi na - 404 Not found
    http_response_code(404);

    // wyswietlenie wiadomosci ze nie podano nipu
    echo json_encode(array(
        "Blad" => "Nie podano ."
    ));
    $num = 0;

}


if ($num > 0) {

    $paymentEndpoint                = array();
    $paymentEndpoint["Endpoint"] = array();

    while ($row = $stmtpaymentEndpoint->fetch(PDO::FETCH_ASSOC)) {

        extract($row);

        $paymentEndpointItem = array(
            "isThisNumber"=>true,
            "senderAccountnumber"=> $sender_number,
            "senderName" => $sender_name,
            "senderAddress"=> $sender_address,
            "recipientAccountnumber"=> $recipent_number,
            "recipientName"=> $recipent_name,
            "recipientAddress"=> $recipent_address,
            "paymentTitle"=> $title,
            "paymentAmount"=> $amount,


        );

    }
    array_push($paymentEndpoint["Endpoint"], $paymentEndpointItem);
    // ustawienie kodu odpowiedzi na - 200 OK
    http_response_code(200);

    // pokazanie towarow w formacie JSON
    echo json_encode($paymentEndpointItem);
} else {


    // ustawienie kodu odpowiedzi na - 404 Not found
    http_response_code(404);

    // wyswietlenie wiadomosci ze nie znaleziono kontrahentow
    echo json_encode(array(
        "isThisNumber" => false,
        "senderAccountnumber"=> $sender_number,
        "senderName" => $sender_name,
        "senderAddress"=> $sender_address,
        "recipientAccountnumber"=> $recipent_number,
        "recipientName"=> $recipent_name,
        "recipientAddress"=> $recipent_address,
        "paymentTitle"=> $title,
        "paymentAmount"=> $amount,

    ));
}

?>