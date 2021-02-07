<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

// dodanie polaczenia z database.php i dodanie obiektu contractor.php
include_once '../../config/database.php';
include_once '../objects/user.php';

// uzyskanie polaczenie z baza danych
$database = new Database();
$db       = $database->getConnection();

// zainicjalizowanie obiektu $contractor
$user = new User($db);
if (isset($_GET['firstname']))
    $stmtUser = $user->searchByFirstName($_GET['firstname']);
elseif (isset($_GET['lastname']))
    $stmtUser = $user->searchByLastName($_GET['lastname']);
elseif (isset($_GET['pesel']))
    $stmtUser = $user->searchByPesel($_GET['pesel']);
elseif (isset($_GET['getType']))
    $stmtUser = $user->searchByLogin($_GET['username'],$_GET['password']);
else
    $stmtUser = $user->readAll();

if (isset($_GET['update']))
    $stmtUser = $user->update($_GET['id'],$_GET['firstname'], $_GET['lastname'],$_GET['pesel'],$_GET['email'],$_GET['telephone'],$_GET['address'],$_GET['username'],$_GET['password'],$_GET['type_user']);

if (isset($_GET['create']))
    $stmtUser = $user->create($_GET['firstname'],$_GET['lastname'],$_GET['pesel'],$_GET['email'],$_GET['telephone'],$_GET['address'],$_GET['username'],$_GET['password'],$_GET['type_user']);
if (isset($_GET['readOne']))
    $stmtUser = $user->readOneUser($_GET['id']);
if (isset($_GET['delete']))
    $stmtUser = $user->delete($_GET['id']);

$num  = $stmtUser->rowCount();

if ($num > 0) {

    $userArray= array();
    $userArray["Users"] = array();

    while ($row = $stmtUser->fetch(PDO::FETCH_ASSOC)) {
        extract($row);
        $userItem = array(
            "id" => $id,
            "firstname" => $firstname,
            "lastname" => $lastname,
            "pesel" => $pesel,
            "email" => $email,
            "telephone" => $telephone,
            "address" => $address,
            "username" => $username,
            "password" => $password,
            "type_user" => $type_user
        );

        array_push($userArray["Users"], $userItem);
    }

    // ustawienie kodu odpowiedzi na - 200 OK
    http_response_code(200);

    // pokazanie towarow w formacie JSON
    echo json_encode($userArray);
} else {

    // ustawienie kodu odpowiedzi na - 404 Not found
    http_response_code(404);

    // wyswietlenie wiadomosci ze nie znaleziono kontrahentow
    echo json_encode(array(
        "Błąd" => "Nie znaleziono Uzytkownikow."
    ));
}

?>
