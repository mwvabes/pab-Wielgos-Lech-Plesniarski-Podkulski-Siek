<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once '../../config/database.php';
include_once '../objects/operation.php';

$database = new Database();
$db       = $database->getConnection();

$operation = new Operation($db);
if(isset($_GET['update']))
    $stmtOperation = $operation->update($_GET['id_operation'], $_GET['title'],$_GET['amount'], $_GET['type_payment'], $_GET['sender_number'], $_GET['sender_name'],$_GET['sender_address'], $_GET['recipent_number'], $_GET['recipent_address'], $_GET['recipent_name'], $_GET['status'], $_GET['date']);
if(isset($_GET['create']))
    $stmtOperation = $operation->create($_GET['id_account'],$_GET['title'],$_GET['amount'], $_GET['type_payment'], $_GET['sender_number'], $_GET['sender_name'],$_GET['sender_address'], $_GET['recipent_number'], $_GET['recipent_address'], $_GET['recipent_name'], $_GET['status'], $_GET['date']);
if((isset($_GET['readAboutAccount'])))
    $stmtOperation = $operation->readOneAccountOperations($_GET['id_account']);
elseif ((isset($_GET['sent'])))
    $stmtOperation = $operation->doPayment($_GET['id_account'],$_GET['account_number'],$_GET['balance'],$_GET['amount'],$_GET['title'],$_GET['recipent_number'],$_GET['recipent_name'],$_GET['recipent_address'],$_GET['sender_name'],$_GET['sender_address'],$_GET['type_payment']);
elseif ((isset($_GET['sentPayback'])))
    $stmtOperation = $operation->doPaymentBack($_GET['sender_number'],$_GET['sender_name'],$_GET['sender_address'],$_GET['recipent_number'],$_GET['recipent_name'],$_GET['recipent_address'],
        $_GET['title'],$_GET['amount']);
elseif ((isset($_GET['readBeforePayment'])))
    $stmtOperation = $operation->readBeforePayment($_GET['id_account']);
else
    $stmtOperation = $operation->readAll();


$num  = $stmtOperation->rowCount();

if ($num > 0) {

    $operationArray               = array();
    $operationArray["Operations"] = array();

    while ($row = $stmtOperation->fetch(PDO::FETCH_ASSOC)) {

        extract($row);

        $operationItem = array(
            "isvalid"=>true,
            "id_operation" => $id_operation,
            "id_account" => $id_account,
            "title" => $title,
            "amount" => $amount,
            "type" => $type,
            "sender_name" => $sender_name,
            "sender_address" => $sender_address,
            "sender_number" => $sender_number,
            "recipent_name" => $recipent_name,
            "recipent_address" => $recipent_address,
            "recipent_number" => $recipent_number,
            "status" => $status,
            "date" => $date
        );
        array_push($operationArray["Operations"], $operationItem);
    }
    http_response_code(200);
    echo json_encode($operationArray);
} else {
    http_response_code(404);
    echo json_encode(array(
        "Błąd" => "Nie znaleziono adresu."
    ));
}

?>
