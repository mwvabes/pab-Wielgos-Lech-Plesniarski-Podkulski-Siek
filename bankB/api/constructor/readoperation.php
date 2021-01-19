<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once '../../config/database.php';
include_once '../objects/operation.php';

$database = new Database();
$db       = $database->getConnection();

$operation = new Operation($db);
if ((isset($_GET['input'])))
    $stmtOperation = $operation->readOne($_GET['input']);
else if(isset($_GET['update']))
    $stmtOperation = $operation->update($_GET['id_operation'], $_GET['title'], $_GET['amount'], $_GET['type'], $_GET['sender_number'], $_GET['recipent_number'], $_GET['status'], $_GET['date']);
if(isset($_GET['create']))
    $stmtOperation = $operation->create($_GET['id_account'], $_GET['title'], $_GET['amount'], $_GET['type'], $_GET['sender_number'], $_GET['recipent_number'], $_GET['status'], $_GET['date']);
else
    $stmtOperation = $operation->readAll();

$num  = $stmtOperation->rowCount();

if ($num > 0) {

    $operationArray               = array();
    $operationArray["Operations"] = array();

    while ($row = $stmtOperation->fetch(PDO::FETCH_ASSOC)) {

        extract($row);

        $operationItem = array(
            "id_operation" => $id_operation,
            "id_account" => $id_account,
            "title" => $title,
            "amount" => $amount,
            "type" => $type,
            "sender_number" => $sender_number,
            "recipent_number" => $recipent_number,
            "status" => $status,
            "date" => $date
        );
        array_push($operationArray["Osoby"], $operationItem);
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
