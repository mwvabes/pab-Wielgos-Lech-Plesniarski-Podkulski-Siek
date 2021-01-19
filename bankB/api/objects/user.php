<?php
class User
{
    private $connection;
    private $table_name = "user";

    public $id;
    public $firstname;
    public $lastname;
    public $pesel;
    public $email;
    public $telephone;
    public $address;
    public $username;
    public $password;
    public $type_user;


    public function __construct($db){
        $this->connection = $db;
    }

    function readAll(){
        $query = "SELECT * FROM  user";
        $stmt = $this->connection->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    function readOne($id){
        $query = "SELECT * FROM user WHERE id = $id";
        $stmt = $this->connection->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    function delete($id){
        $query = "Delete FROM user WHERE id = $id";
        $stmt = $this->connection->prepare($query);
        $stmt->execute();
        return $stmt;
    }
    function searchByFirstName($firstname){
        $query = "SELECT * FROM user WHERE firstname LIKE '%$firstname%' order by firstname";
        $stmt = $this->connection->prepare($query);
        $stmt->execute();
        return $stmt;
    }
    function searchByLastName($lastname){
        $query = "SELECT * FROM user WHERE lastname LIKE '%$lastname%' order by lastname";
        $stmt = $this->connection->prepare($query);
        $stmt->execute();
        return $stmt;
    }
    function searchByPesel($pesel){
        $query = "SELECT * FROM user WHERE pesel LIKE '%$pesel%' order by pesel";
        $stmt = $this->connection->prepare($query);
        $stmt->execute();
        return $stmt;
    }
    function searchByEmail($email){
        $query = "SELECT * FROM user WHERE email LIKE '%$email%' order by email";
        $stmt = $this->connection->prepare($query);
        $stmt->execute();
        return $stmt;
    }
    function searchByTelephone($telephone){
        $query = "SELECT * FROM user WHERE telephone LIKE '%$telephone%' order by telephone";
        $stmt = $this->connection->prepare($query);
        $stmt->execute();
        return $stmt;
    }
    function searchByAddress($address){
        $query = "SELECT * FROM user WHERE address LIKE '%$address%' order by address";
        $stmt = $this->connection->prepare($query);
        $stmt->execute();
        return $stmt;
    }
    function searchByUsername($username){
        $query = "SELECT * FROM user WHERE username LIKE '%$username%' order by username";
        $stmt = $this->connection->prepare($query);
        $stmt->execute();
        return $stmt;
    }
    function searchByPassword($password){
        $query = "SELECT * FROM user WHERE password LIKE '%$password%' order by password";
        $stmt = $this->connection->prepare($query);
        $stmt->execute();
        return $stmt;
    }
    function searchByTypeUser($type_user){
        $query = "SELECT * FROM user WHERE type_user LIKE '%$type_user%' order by type_user";
        $stmt = $this->connection->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    function update($id, $firstname, $lastname, $pesel, $email, $telephone,$address,$username,$password,$type_user){
        $query = "UPDATE user SET firstname = '$firstname',
        lastname = '$lastname', pesel = '$pesel', email = '$email',
        telephone = '$telephone', address = '$address', username = '$username',
        password = '$password', type_user = '$type_user'WHERE id = $id";
        $stmt = $this->connection->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    function create($firstname, $lastname, $pesel, $email, $telephone,$address,$username,$password,$type_user){
        $firstname = htmlspecialchars(strip_tags($firstname));
        $lastname = htmlspecialchars(strip_tags($lastname));
        $pesel = htmlspecialchars(strip_tags($pesel));
        $email = htmlspecialchars(strip_tags($email));
        $telephone = htmlspecialchars(strip_tags($telephone));
        $address = htmlspecialchars(strip_tags($address));
        $username = htmlspecialchars(strip_tags($username));
        $password = htmlspecialchars(strip_tags($password));
        $type_user = htmlspecialchars(strip_tags($type_user));
        $query = "INSERT INTO kontrahent
        (firstname, lastname, pesel, email, telephone,address,username,password,type_user)
        VALUES ('$firstname', '$lastname', '$pesel', ' $email', '$telephone', '$address',' $username', '$password', '$type_user')";
        $stmt  = $this->connection->prepare($query);
        //$stmt->execute();
        if ($stmt->execute()) {
            return $stmt;
        }
        function getId()
        {
            $query = "SELECT id FROM user";
            $stmt = $this->connection->prepare($query);
            $stmt->execute();
            return $stmt;
        }
        return false;
    }
}
?>
