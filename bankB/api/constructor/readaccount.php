<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");


include_once '../../config/database.php';
include_once '../objects/account.php';


$database = new Database();
$db       = $database->getConnection();

$account = new Account($db);

if(isset($_GET['update']))
    $stmtAccount = $account->update( $_GET['id_account'], $_GET['account_number'], $_GET['balance'], $_GET['id_user']);
if(isset($_GET['create']))
    $stmtAccount = $account->create($_GET['account_number'], $_GET['balance'], $_GET['id_user']);
if(isset($_GET['delete']))
    $stmtAccount = $account->delete($_GET['id_account']);

if(isset($_GET['readOneAccount']))
    $stmtAccount = $account->readOneAccount($_GET['id_account']);
elseif(isset($_GET['readOneAccountByNumber']))
    $stmtAccount = $account->readOneAccountByNumber($_GET['account_number']);
elseif(isset($_GET['setAccountBalancePlus']))
    $stmtAccount = $account->settingAccountBalancePlus($_GET['account_number'],$_GET['balance']);
elseif(isset($_GET['setAccountBalanceMinus']))
    $stmtAccount = $account->settingAccountBalanceMinus($_GET['account_number'],$_GET['balance']);
else
    $stmtAccount = $account->readAll();




if(isset($_GET['readMyAccounts']))
    $stmtAccount=$account->showMyAccount($_GET['id_user']);

$num  = $stmtAccount->rowCount();

if ($num > 0) {



    $accountArray= array();
    $accountArray["Accounts"] = array();

    while ($row = $stmtAccount->fetch(PDO::FETCH_ASSOC)) {
        extract($row);
        $accountItem = array(
            "id_account" => $id_account,
            "account_number" => $account_number,
            "balance" => $balance,
            "id_user" => $id_user
        );

        array_push($accountArray["Accounts"], $accountItem);
    }

    http_response_code(200);
    echo json_encode($accountArray);
} else {
    http_response_code(404);
    echo json_encode(array(
        "Błąd" => "Nie znaleziono adresu."
    ));
}
?>
