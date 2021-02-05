<?php
session_start();
$username=$_GET['username'];
$password=$_GET['password'];

    $json = @file_get_contents("http://localhost/bankB/api/constructor/readuser.php?getType=&username=$username&password=$password");

    if ($json) {
        $arr = json_decode($json);
        foreach ($arr->Users as $key => $value)
        {
            $id=$value->id;
            $typo=$value->type_user;

        }

        if($typo=='admin'){
            $_SESSION['zalogowany']=$id;
            header('Location:admin.php');
        }else{
            $_SESSION['zalogowany']=$id;
            header('Location:user.php?id='.$id.'');
        }


    } else {
        header('Location:index.php');
        echo $_SESSION['failed_login']="<h1>Failed to login. Try later again.</h1>";
    }



    ?>
