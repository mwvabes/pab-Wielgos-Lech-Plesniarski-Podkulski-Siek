<?php
header('Acces-Controll-Allow-Origin: *');
header('Content-Type: application/json');

include_once '../../config/database.php';
include_once '../objects/useraccount.php';

$database = new Database();
$db = $database->getConnection();
$useraccount=new UserAccount($db);
if(isset($_GET['readOne']))
    $stmtEverything=$useraccount->readEverythingAccountsOne($_GET['id_user']);
else
    $stmtEverything=$useraccount->readEverythingAccounts();

$num=$stmtEverything->rowCount();

if($num>0){
    $everythingArray= array();
    $everythingArray["UserAccounts"]=array();
    while ($row = $stmtEverything->fetch(PDO::FETCH_ASSOC)) {
        extract($row);
        $everythingItem = array(
            "id" => $id,
            "firstname" => $firstname,
            "lastname" => $lastname,
            "pesel" => $pesel,
            "email" => $email,
            "telephone" => $telephone,
            "address" => $address,
            "username" => $username,
            "password" => $password,
            "type_user" => $type_user,
            "id_account" => $id_account,
            "account_number" => $account_number,
            "balance" => $balance,
            "id_user" => $id_user,


        );
        array_push($everythingArray['UserAccounts'], $everythingItem);
    }
    http_response_code(200);
    echo json_encode($everythingArray);
} else {
    http_response_code(404);
    echo json_encode(array(
        "Błąd" => "Nie znaleziono adresu."
    ));

}





?>