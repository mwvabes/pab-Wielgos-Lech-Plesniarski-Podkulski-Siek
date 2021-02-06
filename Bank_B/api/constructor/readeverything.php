<?php
    header('Acces-Controll-Allow-Origin: *');
    header('Content-Type: application/json');

    include_once '../../config/database.php';
    include_once '../objects/everything.php';

    $database = new Database();
    $db = $database->getConnection();
    $everything=new Everything($db);
    if(isset($_GET['readOne']))
        $stmtEverything=$everything->readOne($_GET['id']);
    else
        $stmtEverything=$everything->readEverythingAccounts();

    $num=$stmtEverything->rowCount();

    if($num>0){
        $everythingArray= array();
        $everythingArray["Everythings"]=array();
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
                "id_operation" => $id_operation,
                "title" => $title,
                "amount" => $amount,
                "type" => $type,
                "sender_number" => $sender_number,
                "recipent_number" => $recipent_number,
                "status" => $status,
                "date" => $date


            );
            array_push($everythingArray['Everythings'], $everythingItem);
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