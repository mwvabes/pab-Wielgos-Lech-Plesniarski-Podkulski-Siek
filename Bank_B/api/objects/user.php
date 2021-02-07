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

    function searchByLogin($username,$password){
        $query = "SELECT * FROM user where username='$username' AND password='$password'";
        $stmt = $this->connection->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    function readOneUser($id){
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
        $query = "INSERT INTO user
        (firstname, lastname, pesel, email, telephone,address,username,password,type_user)
        VALUES ('$firstname', '$lastname', '$pesel', '$email', '$telephone', '$address','$username', '$password', '$type_user')";
        $stmt  = $this->connection->prepare($query);

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
