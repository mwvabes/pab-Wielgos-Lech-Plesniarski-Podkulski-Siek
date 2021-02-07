<?php
session_start();
$id_user=$_SESSION['zalogowany'];

?>
<!DOCTYPE html>
<html lang="pl">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Hello Admin</title>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.11.2/css/all.css">
    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <!-- Material Design Bootstrap -->
    <link href="css/mdb.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <style>
        body{
            min-width: 550px;
        }
        html,
        body,
        header{
            min-height: 30%;
            height: 55%;

        }
    </style>
    <script>
        function reloadHead(){
            location.href = "admin.php";
        }
    </script>
</head>

<body class="salon-lp">

<!-- Navigation & Intro -->
<header>
    <nav class="navbar navbar-expand-lg navbar-dark fixed-top bg-dark wow fadeIn" data-wow-delay="0.15s">
        <div class="container">
            <div class="collapse navbar-collapse" id="navbarTogglerDemo02">
                <ul class="navbar-nav dropdown smooth-scroll">
                    <li class="nav-item">
                        <a class="nav-link" href="#" data-offset="90">
                            <?php  $json = @file_get_contents("http://localhost/bankB/api/constructor/readuser.php?readOne=&id=".$id_user."");
                            if($json) {
                                $arr = json_decode($json);
                                foreach ($arr->Users as $key => $value)
                                { echo "Welcome admin ".$value->firstname." ".$value->lastname;

                                }
                            }else{
                                echo "Not Found a User";
                            }
                            ?>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</header>
<main>
    <div class="container-fluid">
        <iframe name="dummyframe" id="dummyframe" style="display: none;"></iframe>
        <h4 class="h5-responsive dark-grey-text font-weight-bold mb-5 text-center">
            <form method="get">
                <button type="submit" class="btn btn-primary" name="set_table" value="Users">Users</button>
                <button type="submit" class="btn btn-primary" name="set_table" value="Accounts">Accounts</button>
                <button type="submit" class="btn btn-primary" name="set_table" value="Operations">Operations</button>
                <button type="submit" class="btn btn-primary" name="set_table" value="take">Take list of paymients</button>
                <button type="submit" class="btn btn-primary" name="set_table" value="Logout">Logout</button>
            </form>
        </h4>

        <?php
        if(isset($_SESSION['fails_payment'])){
                echo"<div class=\"card mb-3 mr-5 ml-5 text-center\"><div class=\"card-body\"><h1>";
                echo $_SESSION['fails_payment'];
                echo "</h1></div></div>";
            unset($_SESSION['fails_payment']);
        }
        if (isset($_GET['set_table']) && $_GET['set_table'] == 'Logout')
        {
            session_destroy();
            header("Location:index.php");
        }

        if (isset($_GET['set_table']) && $_GET['set_table'] == 'Users')
        {
            ?>

            <div class="card mb-3 mr-5 ml-5 text-center">
            <div class="card-body">
                <table class="table">
                <thead>
                <th>Firstname</th>
                <th>Lastname</th>
                <th>Pesel</th>
                <th>Email</th>
                <th>Telephone number</th>
                <th>Address </th>
                <th>Login </th>
                <th>Password </th>
                <th>Type of Account </th>

                <th colspan="2">More</th>
                </thead>
                <tbody>
            <?php
            $json = @file_get_contents("http://localhost/bankB/api/constructor/readuser.php");

            if ($json)
            {
                $arr = json_decode($json);
                foreach ($arr->Users as $key => $value)
                {
                    ?>
                    <form method='get'>
                        <tr>
                            <input type="hidden" value="<?php echo $value->id; ?>" name="id"/>
                            <td><?php echo $value->firstname; ?></td>
                            <td><?php echo $value->lastname; ?></td>
                            <td><?php echo $value->pesel; ?></td>
                            <td><?php echo $value->email; ?></td>
                            <td><?php echo $value->telephone; ?></td>
                            <td><?php echo $value->address; ?></td>
                            <td><?php echo $value->username; ?></td>
                                <td> hidden </td>
                            <td><?php echo $value->type_user; ?></td>

                            <?php if($value->type_user=='admin' && $value->id!=$id_user){

                            }else{
                                ?>
                                <td><button class="btn btn-primary btn-sm" type="submit" name="action" value="edit user">Edit User</button></td>
                                <td><button class="btn btn-primary btn-sm" type="submit" name="action" value="delete user">Delete User</button></td>
                                <?php
                            }?>

                        </tr>
                    </form>
                    <?php
                }?>
                </tbody>
                </table>
                <form method="get">
                    <button class="btn btn-primary btn-sm"  type="submit" name="add" value="Add User">Add New User</button>
                </form>
                </div>
                </div>
                <?php
            }
            else
            { ?>
                <div class="card mb-3 mr-5 ml-5 text-center">
                    <div class="card-body">
                        <h1>Not found anything</h1>
                        <form method="get">
                            <button class="btn btn-primary btn-sm"  type="submit" name="add" value="Add User">Add New User</button>
                        </form>
                    </div>
                </div>
                <?php
            }
        }

        if (isset($_GET['set_table']) && $_GET['set_table'] == 'Accounts') {?>
            <div class="card mb-3 mr-5 ml-5 text-center">
            <div class="card-body">
            <table class="table">
            <thead>
            <th>Account number</th>
            <th>Balance</th>
            <th>Name</th>
            <th>Pesel</th>
            <th colspan="3">Więcej</th>
            </thead>
            <tbody>
            <?php
            $json = @file_get_contents("http://localhost/bankB/api/constructor/readuseraccount.php");
            if($json)
            {
                $arr = json_decode($json);
                foreach ($arr->UserAccounts as $key => $value)
                {

                    ?>
                    <form method='get'>
                        <tr>
                            <input type="hidden" value="<?php echo $value->id_account; ?>" name="id_account"/>
                            <input type="hidden" value="<?php echo $value->account_number; ?>" name="account_number"/>
                            <td><?php echo readAccountNumber($value->account_number); ?></td>
                            <td><?php echo $value->balance." zł"; ?></td>
                            <td><?php echo $value->firstname." ".$value->lastname; ?></td>
                            <td><?php echo $value->pesel; ?></td>
                            <td><button class="btn btn-primary btn-sm" type="submit" name="action" value="edit account">Edit Account</button>
                            <button class="btn btn-primary btn-sm" type="submit" name="action" value="delete account">Delete Account</button>
                            <button class="btn btn-primary btn-sm" type="submit" name="action" value="show">Payment Details Account</button></td>
                        </tr>
                    </form>
                <?php } ?>
                </tbody>
                </table>

                <form method="get">
                    <button class="btn btn-primary btn-sm"  type="submit" name="add" value="Add Account">Add New Account </button>
                </form>
                </div>
                </div>
                <?php
            }else{
                ?>
                <div class="card mb-3 mr-5 ml-5 text-center">
                    <div class="card-body">
                        <h1>Not found anything</h1>
                        <form method="get">
                            <button class="btn btn-primary btn-sm"  type="submit" name="add" value="Add Account">Add New Account </button>
                        </form>
                    </div>
                </div>
                <?php
            }
        }?>

        <?php
        if (isset($_GET['action']) && $_GET['action'] == 'show'){
        ?>

    <?php
    $json = @file_get_contents("http://localhost/bankB/api/constructor/readoperation.php?readAboutAccount=&id_account=".$_GET['id_account']);


    if($json){
    ?>
        <div class="card mb-3 mr-5 ml-5 text-center">
            <div class="card-body">
                <table class="table">
                    <thead>
                    <th> Sender's Account </th>
                    <th> Sender's Name </th>
                    <th> Sender's Address </th>
                    <th> Recipent's Account </th>
                    <th> Recipent's Name </th>
                    <th> Recipent's Address </th>
                    <th> Title</th>
                    <th> Amount</th>
                    <th> Status </th>
                    <th> Date</th>
                    </thead>
                    <tbody>
                    <?php
                    $arr = json_decode($json);
                    foreach ($arr->Operations as $key => $value)

                    {
                        ?>

                        <tr>
                            <input type="hidden" value="<?php echo $value->id_operation; ?>" name="id"/>
                            <input type="hidden" value="<?php echo $value->id_account; ?>" name="id_account"/>
                            <input type="hidden" value="<?php echo $value->account_number; ?>" name="account_number"/>
                            <td><?php echo readAccountNumber($value->sender_number); ?></td>
                            <td><?php echo $value->sender_name; ?></td>
                            <td><?php echo $value->sender_address; ?></td>
                            <td><?php echo readAccountNumber($value->recipent_number); ?></td>
                            <td><?php echo $value->recipent_name; ?></td>
                            <td><?php echo $value->recipent_address; ?></td>
                            <td><?php echo $value->title; ?></td>
                            <?php if(($value->status)=='completed' ||($value->status)=='sended'){
                                ?><td><?php echo "-".$value->amount. " zł"; ?></td><?php
                            }else{
                                ?><td><?php echo $value->amount." zł"; ?></td><?php
                            }
                            ?>

                            <td><?php echo $value->status; ?></td>
                            <td><?php echo $value->date; ?></td>
                        </tr>

                    <?php } ?>
                    </tbody>
                </table>
                <?php
                }else{
                    ?>
        <div class="card mb-3 mr-5 ml-5 text-center">
            <div class="card-body">
                <h1>Not found any operation.</h1>
            </div>
        </div>
        <?php
                }
                ?>
                <?php
                $json = @file_get_contents("http://localhost/bankB/api/constructor/readaccount.php?readOneAccount=&id_account=".$_GET['id_account']."");
                if($json){
                    $arr = json_decode($json);
                    foreach ($arr->Accounts as $key => $value) {
                        ?>
                <div class="mb-3 mr-5 ml-5 text-center">

                        <form method='get'>
                            <input type="hidden" value="<?php echo $value->id_account; ?>" name="id_account"/>
                            <button class="btn btn-primary" type="submit" name="action" value="do_payment">Do Payment</button>
                        </form>

                </div>
                        <?php
                    }

                } else
                {
                    ?><div class="card mb-3 mr-5 ml-5 text-center">
                    <div class="card-body">
                        <h1>Not found any account's to do payment</h1>
                    </div>
                </div> <?php
                }
        ?>
            </div>
            </div>
                <?php
        }
                ?>

        <?php
        if (isset($_GET['action']) && $_GET['action'] == 'do_payment')
        {
            ?>
            <?php
            $json = @file_get_contents("http://localhost/bankB/api/constructor/readaccount.php?readOneAccount=&id_account=".$_GET['id_account']);

            if ($json)
            {
                $arr = json_decode($json);
                foreach ($arr->Accounts as $key => $value)
                {

                    ?>
                    <div class="container pt-5">
                        <div class="h-100 d-flex justify-content-center align-items-center">
                            <div class="row smooth-scroll col-7">
                                <div class="col-12 text-center">
                                    <div class="card mb-3 mr-5 ml-5 text-center">
                                        <div class="card-body">
                                            <form  method="get" action="http://localhost/bankB/api/constructor/readoperation.php?sent=" target="dummyframe" onsubmit="setTimeout(function(){location.replace('http://localhost/bankB/admin.php');},10);">
                                                <input type="hidden" value="<?php echo $value->id_account; ?>" name="id_account"/>
                                                <input type="hidden" value="<?php echo $pros=$value->id_user; ?>" name="id_user"/>
                                                <input type="hidden" value="<?php echo $value->account_number; ?>"name="account_number" class="form-control">
                                                <div>
                                                    <h4><strong>Your account number: </strong></h4>
                                                    <input type="text" value="<?php echo readAccountNumber($value->account_number); ?>"name="showing" class="form-control" readonly>

                                                </div>
                                                <div class="form-group">
                                                    <h4><strong>Your balance: </strong></h4>
                                                    <input type="text" value="<?php echo $value->balance; ?>"name="balance" class="form-control" readonly>
                                                </div>
                                                <?php
                                                $json = @file_get_contents("http://localhost/bankB/api/constructor/readuseraccount.php?readOne=&id_user=".$pros."");

                                                if ($json)
                                                {
                                                    $arr = json_decode($json);
                                                    foreach ($arr->UserAccounts as $key => $value)
                                                    {

                                                        ?>
                                                        <div class="form-group">
                                                            <h4><strong>Sender's name: </strong></h4>
                                                            <input type="text" value="<?php echo $value->firstname." ".$value->lastname;?>" name="sender_name" class="form-control" readonly>
                                                        </div>
                                                        <div class="form-group">
                                                            <h4><strong>Sender's Address: </strong></h4>
                                                            <input type="text" value="<?php echo $value->address; ?>" name="sender_address" class="form-control" readonly>
                                                        </div>
                                                        <?php
                                                    }
                                                } else {
                                                    ?> <div class="card mb-3 mr-5 ml-5 text-center">
            <div class="card-body">
                <h1>Not found users.</h1>
            </div>
        </div>
            <?php
                                                }

                                                ?>

                                                <div class="form-group">
                                                    <h4><strong>Title: </strong></h4>
                                                    <input type="text" name="title" class="form-control" read>
                                                </div>
                                                <div class="form-group">
                                                    <h4><strong>Amount: </strong></h4>
                                                    <input type="text" name="amount" class="form-control" required>
                                                </div>
                                                <div class="form-group">
                                                    <h4><strong>Recipnent's account number: </strong></h4>
                                                    <input type="text" name="recipent_number" class="form-control" required>
                                                </div>
                                                <div class="form-group">
                                                    <h4><strong>Recipnent's account name: </strong></h4>
                                                    <input type="text" name="recipent_name" class="form-control" required>
                                                </div>
                                                <div class="form-group">
                                                    <h4><strong>Recipnent's account address: </strong></h4>
                                                    <input type="text" name="recipent_address" class="form-control" required>
                                                </div>
                                                <div class="form-group">
                                                <h4><strong>Type of Payment: </strong></h4>
                                                <select class="custom-select mr-sm-2" name="type_payment">
                                                    <option value="normal" selected>Normal</option>
                                                    <option value="express">Express (2.50 zł extra)</option>

                                                </select>
                                        </div>
                                                <button type="submit" name="sent" value="sent" class="btn btn-primary">Send Payment</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php

            }}else {
                ?> <div class="card mb-3 mr-5 ml-5 text-center">
            <div class="card-body">
                <h1>Failed to send payment.</h1>
            </div>
        </div><?php
        }
        }
        ?>





        <?php


        if (isset($_GET['set_table']) && $_GET['set_table'] == 'Operations')
        {
            ?>

            <div class="card mb-3 mr-5 ml-5 text-center">
            <div class="card-body">
                <table class="table">
                <thead>
                <th>Name</th>
                <th>Pesel</th>
                <th>Title</th>
                <th>Type</th>
                <th>Sender number</th>
                <th>Recipent Number </th>
                <th>Amount </th>
                <th>Status</th>
                <th>Date</th>
                </thead>
                <tbody>
            <?php
            $json = @file_get_contents("http://localhost/bankB/api/constructor/readeverything.php");

            if ($json)
            {
                $arr = json_decode($json);
                foreach ($arr->Everythings as $key => $value)
                {
                    ?>
                    <form method='get'>
                        <tr>
                            <input type="hidden" value="<?php echo $value->id_operation; ?>" name="id_operation"/>
                            <td><?php echo $value->firstname." ".$value->lastname; ?></td>
                            <td><?php echo $value->pesel; ?></td>
                            <td><?php echo $value->title; ?></td>
                            <td><?php echo $value->type; ?></td>
                            <td><?php echo readAccountNumber($value->sender_number); ?></td>
                            <td><?php echo readAccountNumber($value->recipent_number); ?></td>
                            <?php if($value->status=='completed' || ($value->status)=='sended'){
                                ?>
                                <td><?php echo "-".$value->amount." zł"; ?></td>
                                <?php
                            }else{
                                ?>
                                <td><?php echo $value->amount." zł"; ?></td>
                                <?php
                            }?>

                            <td><?php echo $value->status; ?></td>
                            <td><?php echo $value->date; ?></td>
                        </tr>
                    </form>
                    <?php
                }?>
                </tbody>
                </table>
                </div>
                </div>
                <?php
            }
            else
            {
                echo "Nie znaleziono rekordów.";
            }
                }
?>








        <?php
        if (isset($_GET['add']) && $_GET['add'] == 'Add User')
        {
            ?>
            <div class="container pt-5">
                <div class="h-100 d-flex justify-content-center align-items-center">
                    <div class="row smooth-scroll col-7">
                        <div class="col-12 text-center">
                            <div class="card mb-3 mr-5 ml-5 text-center">
                                <div class="card-body">
                                    <form  method="get" action="http://localhost/bankB/api/constructor/readuser.php?create=" target="dummyframe" onsubmit="setTimeout(function(){location.replace('http://localhost/bankB/admin.php?set_table=Users');},10);">
                                        <div class="form-group">
                                            <h4><strong>Firstname: </strong></h4>
                                            <input type="text" name="firstname" class="form-control" required>
                                        </div>
                                        <div class="form-group">
                                            <h4><strong>Lastname: </strong></h4>
                                            <input type="text" name="lastname" class="form-control" required>
                                        </div>
                                        <div class="form-group">
                                            <h4><strong>Pesel: </strong></h4>
                                            <input type="text" name="pesel" class="form-control" required>
                                        </div>
                                        <div class="form-group">
                                            <h4><strong>Email: </strong></h4>
                                            <input type="text" name="email" class="form-control" required>
                                        </div>
                                        <div class="form-group">
                                            <h4><strong>Telephone: </strong></h4>
                                            <input type="text" name="telephone" class="form-control" required>
                                        </div>
                                        <div class="form-group">
                                            <h4><strong>Address: </strong></h4>
                                            <input type="text" name="address" class="form-control" required>
                                        </div>

                                        <div class="form-group">
                                            <h4><strong>Username: </strong></h4>
                                            <input type="text" name="username" class="form-control" required>
                                        </div>
                                        <div class="form-group">
                                            <h4><strong>Password: </strong></h4>
                                            <input type="text" name="password" class="form-control" required>
                                        </div>
                                        <div class="form-group">
                                            <h4><strong>Type_user: </strong></h4>
                                            <input type="text" name="type_user" class="form-control" required>
                                        </div>
                                        <button type="submit" name="create" value="Dodaj" class="btn btn-primary">Add User</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <?php
        }
        if (isset($_GET['add']) && $_GET['add'] == 'Add Account')
        {
            ?>
            <div class="container pt-5">
                <div class="h-100 d-flex justify-content-center align-items-center">
                    <div class="row smooth-scroll col-7">
                        <div class="col-12 text-center">
                            <div class="card mb-3 mr-5 ml-5 text-center">
                                <div class="card-body">
                                    <form  method="get" action="http://localhost/bankB/api/constructor/readaccount.php?create=" target="dummyframe" onsubmit="setTimeout(function(){location.replace('http://localhost/bankB/admin.php?set_table=Accounts');},10);">
                                        <input type="hidden" value="1" name="id_user"/>
                                        <div class="form-group">
                                            <h4><strong>Account Number: </strong></h4><?php  $check=getAccountNumber('10504475'); ?>
                                            <input type="hidden" name="account_number" value="<?php echo "".$check; ?>" class="form-control" readonly>
                                            <input type="text" name="showing" value="<?php echo "".readAccountNumber($check); ?>" class="form-control" readonly>
                                        </div>
                                        <div class="form-group">
                                            <h4><strong>Balance: </strong></h4>
                                            <input type="text" name="balance" class="form-control" required>
                                        </div>
                                        <button type="submit" name="create" value="Utwórz" class="btn btn-primary">Add Account</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <?php
        }

        if (isset($_GET['action']) && $_GET['action'] == 'edit user') {
            $json = @file_get_contents("http://localhost/bankB/api/constructor/readuser.php?readOne=&id=".$_GET['id']);

            if ($json)
            {
                $arr = json_decode($json);
                foreach ($arr->Users as $key => $value)
                {
                    ?>
                    <div class="container pt-5">
                        <div class="h-100 d-flex justify-content-center align-items-center">
                            <div class="row smooth-scroll col-7">
                                <div class="col-12 text-center">
                                    <div class="card mb-3 mr-5 ml-5 text-center">
                                        <div class="card-body">
                                            <form  method="get" action="http://localhost/bankB/api/constructor/readuser.php?update=" target="dummyframe" onsubmit="setTimeout(function(){location.replace('http://localhost/bankB/admin.php?set_table=Users');},10);">
                                                <input type="hidden" value="<?php echo $value->id; ?>" name="id"/>
                                                <div class="form-group">
                                                    <h4><strong>Firstname: </strong></h4>
                                                    <input type="text" value="<?php echo $value->firstname; ?>"name="firstname" class="form-control" required>
                                                </div>
                                                <div class="form-group">
                                                    <h4><strong>Lastname: </strong></h4>
                                                    <input type="text" value="<?php echo $value->lastname; ?>"name="lastname" class="form-control" required>
                                                </div>
                                                <div class="form-group">
                                                    <h4><strong>Pesel: </strong></h4>
                                                    <input type="text" value="<?php echo $value->pesel; ?>"name="pesel" class="form-control" required>
                                                </div>
                                                <div class="form-group">
                                                    <h4><strong>Email: </strong></h4>
                                                    <input type="text" value="<?php echo $value->email; ?>" name="email" class="form-control" required>
                                                </div>
                                                <div class="form-group">
                                                    <h4><strong>Telephone: </strong></h4>
                                                    <input type="text" value="<?php echo $value->telephone; ?>" name="telephone" class="form-control" required>
                                                </div>
                                                <div class="form-group">
                                                    <h4><strong>Address: </strong></h4>
                                                    <input type="text" value="<?php echo $value->address; ?>" name="address"  class="form-control" required>
                                                </div>
                                                <div class="form-group">
                                                    <h4><strong>Password: </strong></h4>
                                                    <input type="text" value="<?php echo $value->username; ?>" name="username"  class="form-control" required>
                                                </div>
                                                <div class="form-group">
                                                    <h4><strong>Password: </strong></h4>
                                                    <input type="text" value="<?php echo $value->password; ?>" name="password" class="form-control" required>
                                                </div>
                                                <div class="form-group">
                                                    <h4><strong>Type user: </strong></h4>
                                                    <input type="text" value="<?php echo $value->type_user; ?>" name="type_user"  class="form-control" required>
                                                </div>
                                                <button type="submit" name="update" value="update" class="btn btn-primary">Save User's Changes</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                    <?php
                }
            } else {
                echo "Nie znaleziono rekordów.";
            }
        }

        ?>


        <?php
        if (isset($_GET['action']) && $_GET['action'] == 'edit account')
        {
            $json = @file_get_contents("http://localhost/bankB/api/constructor/readaccount.php?readOneAccount=&id_account=".$_GET['id_account']);

            if ($json){
                $arr = json_decode($json);
                foreach ($arr->Accounts as $key => $value){
                    ?>
                    <div class="container pt-5">
                    <div class="h-100 d-flex justify-content-center align-items-center">
                    <div class="row smooth-scroll col-7">
                    <div class="col-12 text-center">
                    <div class="card mb-3 mr-5 ml-5 text-center">
                    <div class="card-body">
                    <form  method="get" action="http://localhost/bankB/api/constructor/readaccount.php?update=" target="dummyframe" onsubmit="setTimeout(function(){location.replace('http://localhost/bankB/admin.php?set_table=Accounts');},10);">
                    <input type="hidden" value="<?php echo $value->id_account; ?>" name="id_account"/>
                    <input type="hidden" value="<?php $setselected=$value->id_user; ?>" name="id_user"/>
                    <input type="hidden" value="<?php echo $value->account_number; ?>"name="account_number"  class="form-control" readonly>
                    <div class="form-group">
                        <h4><strong>Account Number: </strong></h4>
                        <input type="text" value="<?php echo readAccountNumber($value->account_number); ?>"name="showing"  class="form-control" readonly>
                    </div>
                    <div class="form-group">
                        <h4><strong>Balance: </strong></h4>
                        <input type="text" value="<?php echo $value->balance; ?>"name="balance" class="form-control" required>
                    </div>
                    <div class="form-group">
                    <h4><strong>User: </strong></h4>
                    <?php
                    $json = @file_get_contents("http://localhost/bankB/api/constructor/readuser.php");

                    if($json) {
                        $arr = json_decode($json);
                        ?>
                        <select id="select_user" name="id_user">
                            <?php
                            foreach ($arr->Users as $key => $value) {
                                if($setselected==$value->id){
                                    ?>
                                    <option  value="<?php echo $value->id ?>" selected><?php echo"".$value->firstname." ".$value->lastname." ".$value->pesel ?></option>
                                    <?php
                                }else{
                                    ?>
                                    <option value="<?php echo $value->id ?>"><?php echo"".$value->firstname." ".$value->lastname." ".$value->pesel ?></option>
                                    <?php
                                }

                            }
                            ?>
                        </select>
                        </div>
                        <button type="submit" name="update" value="update" class="btn btn-primary">Save User's Changes</button>
                        </form>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>

                        <?php
                    }else{
                        echo "Nie znaleziono rekordów.";
                    }
                }
            }else{
                echo "Nie znaleziono rekordów.";
            } ?>
            <?php

        }
        ?>

        <?php
        // usun
        if (isset($_GET['action']) && $_GET['action'] == 'delete user')
        {

        $json = @file_get_contents("http://localhost/bankB/api/constructor/readuser.php?readOne=&id=".$_GET['id']);

        if ($json)
        {
        $arr = json_decode($json);
        foreach ($arr->Users as $key => $value)
        {
        ?>
        <div class="container pt-5">
            <div class="h-100 d-flex justify-content-center align-items-center">
                <div class="row smooth-scroll col-7">
                    <div class="col-12 text-center">
                        <div class="card mb-3 mr-5 ml-5 text-center">
                            <div class="card-body">
                                <form  method="get" action="http://localhost/bankB/api/constructor/readuser.php?delete=&id=<?php echo $value-> id;?>" target="dummyframe" onsubmit="setTimeout(function(){location.replace('http://localhost/bankB/admin.php?set_table=Users');},10);">
                                    <input type="hidden" value="<?php echo $value->id; ?>" name="id"/>
                                    <div class="form-group">
                                        <h4><strong>Firstname: </strong></h4>
                                        <input type="text" value="<?php echo $value->firstname; ?>"name="firstname" class="form-control" readonly>
                                    </div>
                                    <div class="form-group">
                                        <h4><strong>Lastname: </strong></h4>
                                        <input type="text" value="<?php echo $value->lastname; ?>"name="lastname" class="form-control" readonly>
                                    </div>
                                    <div class="form-group">
                                        <h4><strong>Pesel: </strong></h4>
                                        <input type="text" value="<?php echo $value->pesel; ?>"name="pesel" class="form-control" readonly>
                                    </div>
                                    <div class="form-group">
                                        <h4><strong>Email: </strong></h4>
                                        <input type="text" value="<?php echo $value->email; ?>" name="email" class="form-control" readonly>
                                    </div>
                                    <div class="form-group">
                                        <h4><strong>Telephone: </strong></h4>
                                        <input type="text" value="<?php echo $value->telephone; ?>" name="telephone" class="form-control" readonly>
                                    </div>
                                    <div class="form-group">
                                        <h4><strong>Address: </strong></h4>
                                        <input type="text" value="<?php echo $value->address; ?>" name="address"  class="form-control" readonly>
                                    </div>
                                    <div class="form-group">
                                        <h4><strong>Password: </strong></h4>
                                        <input type="text" value="<?php echo $value->username; ?>" name="username"  class="form-control" readonly>
                                    </div>
                                    <div class="form-group">
                                        <h4><strong>Password: </strong></h4>
                                        <input type="text" value="<?php echo $value->password; ?>" name="password" class="form-control" readonly>
                                    </div>
                                    <div class="form-group">
                                        <h4><strong>Type user: </strong></h4>
                                        <input type="text" value="<?php echo $value->type_user; ?>" name="type_user"  class="form-control" readonly>
                                    </div>
                                    <button type="submit" name="delete" value="delete" class="btn btn-primary">Delete User</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <?php
                }
            } else {
                echo "Nie znaleziono rekordów.";
            }
        }
        ?>


        <?php

        if (isset($_GET['action']) && $_GET['action'] == 'delete account')
        {

            $json = @file_get_contents("http://localhost/bankB/api/constructor/readaccount.php?readOneAccount=&id_account=".$_GET['id_account']);

        if ($json){
        $arr = json_decode($json);
        foreach ($arr->Accounts as $key => $value){
        ?>
        <div class="container pt-5">
            <div class="h-100 d-flex justify-content-center align-items-center">
                <div class="row smooth-scroll col-7">
                    <div class="col-12 text-center">
                        <div class="card mb-3 mr-5 ml-5 text-center">
                            <div class="card-body">
                            <form  method="get" action="http://localhost/bankB/api/constructor/readaccount.php?delete=&id=<?php echo $value-> id_account;?>" target="dummyframe" onsubmit="setTimeout(function(){location.replace('http://localhost/bankB/admin.php?set_table=Accounts');},10);">
                                    <input type="hidden" value="<?php echo $value->id_account; ?>" name="id_account"/>
                                    <div class="form-group">
                                        <h4><strong>Account Number: </strong></h4>
                                        <input type="text" value="<?php echo $value->account_number; ?>"name="account_number"  class="form-control" readonly>
                                    </div>
                                    <div class="form-group">
                                        <h4><strong>Balance: </strong></h4>
                                        <input type="text" value="<?php echo $value->balance; ?>"name="balance" class="form-control" readonly>
                                    </div>
                                    <div class="form-group">
                                        <h4><strong>User: </strong></h4>
                                        <?php
                                        $json = @file_get_contents("http://localhost/bankB/api/constructor/readuser.php?readOne=&id=".$value->id_user."");

                                        if($json) {
                                        $arr = json_decode($json);
                                        ?>
                                            <select id="select_user" name="id_user">
                                                <?php
                                                foreach ($arr->Users as $key => $value) {
                                                    if($setselected==$value->id){
                                                        ?>
                                                        <option  value="<?php echo $value->id ?>" selected><?php echo"".$value->firstname." ".$value->lastname." ".$value->pesel ?></option>
                                                        <?php
                                                    }else{
                                                        ?>
                                                        <option value="<?php echo $value->id ?>"><?php echo"".$value->firstname." ".$value->lastname." ".$value->pesel ?></option>
                                                        <?php
                                                    }

                                                }
                                                ?>
                                            </select>
                                    </div>
                                    <button type="submit" name="delete" value="delete" class="btn btn-primary">Delete Account</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <?php
                    }else{
                        echo "Nie znaleziono rekordów.";
                    }
                }
            }else{
                echo "Nie znaleziono rekordów.";
            }
        }?>

        <?php
        if (isset($_GET['set_table']) && $_GET['set_table'] == 'take') {

            ?>
        <div class="card mb-3 mr-5 ml-5 text-center">
        <div class="card-body">


            <?php
            //pobranie listy
            $result = getPaymentList();
            //jezeli sa dostepne przelewy to wykonaj
            if($result) {
                $arr = json_decode($result);
                foreach ($arr->r as $key => $value) { //przypisanie pobranych wartosci
                    $senderAccountNumber=$value->senderAccountnumber;
                    $recipentAccountNumber=$value->recipientAccountnumber;
                    $senderName=rawurlencode($value->senderName);
                    $senderAddress=rawurlencode($value->senderAddress);
                    $recipientName=rawurlencode($value->recipientName);
                    $recipientAddress=rawurlencode($value->recipientAddress);
                    $paymentTitle=rawurlencode($value->paymentTitle);
                    $paymentAmount=$value->paymentAmount;
                    $paymentStatus=$value->paymentStatus;

                    // sprawdzenie czy jest taki numer w banku
                    @$json1 = file_get_contents("http://localhost/bankB/api/constructor/readaccount.php?readOneAccountByNumber=&account_number=".$recipentAccountNumber);
                    if($json1){
                        $arr = json_decode($json1);
                        foreach ($arr->Accounts as $key => $value) {
                            $id_account = $value->id_account;
                        }
                        //Zapisanie przelewu otrzymanego w banku
                        $json2 = @file_get_contents("http://localhost/bankB/api/constructor/readoperation.php?create=&id_account=".$id_account."&title=".$paymentTitle.
                            "&amount=".$paymentAmount."&type_payment=outside&sender_number=".$senderAccountNumber."&sender_name=".$senderName."&sender_address=".$senderAddress.
                            "&recipent_number=".$recipentAccountNumber."&recipent_address=".$recipientName."&recipent_name=".$recipientAddress."&status=".$paymentStatus."&date=NOW()");
                        if($json2){//przypisanie otrzymanie kwoty

                            $json4= @file_get_contents("http://localhost/bankB/api/constructor/readaccount.php?setAccountBalancePlus=&account_number=".$recipentAccountNumber."&balance=".$paymentAmount);
                            if($json4){//powiodlo sie
                                echo "<h1>Cash from sender from Bank A user: success</h1>";
                            }else{
                                echo "<h1>Cash from sender from Bank A user: failed</h1>";
                            }

                        }else{
                            echo "save payment to recipient failed <br/>";
                        }
                    }else{// jesli nie znaleziono takiego numeru to zapis na zwrot bankowy i wykonanie przelewu powrotnego
                        $json4=file_get_contents("http://localhost/bankB/api/constructor/readoperation.php?sentPayback=&sender_number=".
                            $senderAccountNumber."&sender_name=".$senderName."&sender_address=".$senderAddress."&recipent_number=".$recipentAccountNumber.
                            "&recipent_name=".$recipientName."&recipent_address=".$recipientAddress."&title=".$paymentTitle."&amount=".$paymentAmount);
                        if($json4){
                            echo "<h1>Send Payback to sender from bank A user:success</h1>";
                        }else{
                            echo "<h1>Send Payback to sender from bank A user:failed</h1>";
                        }
                    }

                }
            }else{//nothing

            }

            ?>
        </div>
        </div>

            <?php


        }
        ?>

    </div>
</main>
<script type="text/javascript" src="js/jquery-3.4.1.min.js"></script>
<script type="text/javascript" src="js/popper.min.js"></script>
<script type="text/javascript" src="js/bootstrap.min.js"></script>
<script type="text/javascript" src="js/mdb.min.js"></script>
<script>
    // Animation init
    new WOW().init();

    // MDB Lightbox Init
    $(function () {
        $("#mdb-lightbox-ui").load("/mdb-addons/mdb-lightbox-ui.html");
    });
</script>
</body>
</html>











<?php
function getAccountNumber($odzial)
{
    do{
        $first=$odzial;
        for ($i = 1; $i <= 16; $i++) {
            $first = $first . rand(1, 9);
        }
        $first = $first . "252100";
        $first1 = substr($first, 0, 6);
        $first1 = $first1 % 97;
        $first1 = $first1 . substr($first, 6, 4);
        $first1 = (int)$first1 % 97;
        $first1 = $first1 . substr($first, 10, 4);
        $first1 = (int)$first1 % 97;
        $first1 = $first1 . substr($first, 14, 4);
        $first1 = (int)$first1 % 97;
        $first1 = $first1 . substr($first, 18, 4);
        $first1 = (int)$first1 % 97;
        $first1 = $first1 . substr($first, 22, 4);
        $first1 = (int)$first1 % 97;
        $first1 = $first1 . substr($first, 26, 4);
        $check = $first1;

        $first1 = (int)$first1 % 97;

        $first1 = 98 - (int)$first1;
        if (strlen($first1) == 1) {
            $first1 = '0' . $first1;
        }
        $check = substr($check, 0, strlen($check - 2));

        $check = $check . $first1;
        $check = $check % 97;
    } while ($check != 1);

    $first = 'PL' . $first1 . $first;

    $first = substr($first, 0, 28);
    //  echo "first po dodaniu hehe:  " . $first;
    return $first;
}
function readAccountNumber($odzial)
{
    $first=$odzial;
    $check="";
    $first1=substr($first,0,2);
    $check=$check.$first1." ";
    $first1=substr($first,2,2);
    $check=$check.$first1." ";
    $first1=substr($first,4,4);
    $check=$check.$first1." ";
    $first1=substr($first,8,4);
    $check=$check.$first1." ";
    $first1=substr($first,12,4);
    $check=$check.$first1." ";
    $first1=substr($first,16,4);
    $check=$check.$first1." ";
    $first1=substr($first,20,4);
    $check=$check.$first1." ";
    $first1=substr($first,24,4);
    $check=$check.$first1;
    return $check;
}

function getPaymentList(){
    $url = 'https://jr-api-express.herokuapp.com/api/auth/login';
    $url1 = 'https://jr-api-express.herokuapp.com/api/payment/getIncoming/?bankCode=105';
    $data = array('username' => 'b105', 'password' => 'operator6');

    $curl = curl_init($url);
    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($data));
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    $get_token = curl_exec($curl);
    curl_close($curl);
    $result = json_decode($get_token,true);
    $token=$result['token'];

    $curl = curl_init($url1);
    curl_setopt($curl, CURLOPT_HTTPHEADER, array(
        'Authorization: ' . $token,
    ));
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($curl);
    curl_close($curl);
    return $response;
}
?>