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
    <title>Hello in Bank B Daily</title>
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
            location.href = "user.php?id=<?php echo $_SESSION['zalogowany']; ?>";
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
                                        { echo "This is your bank ".$value->firstname." ".$value->lastname;

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
                <button type="submit" class="btn btn-primary" name="set_table" value="Show me">Your personal data</button>
                <button type="submit" class="btn btn-primary" name="set_table" value="Accounts">Your accounts</button>
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

        if (isset($_GET['set_table']) && $_GET['set_table'] == 'Show me')
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
                <th colspan="2">More</th>
                </thead>
                <tbody>
                <?php
                $json = @file_get_contents("http://localhost/bankB/api/constructor/readuser.php?readOne=&id=".$id_user."");

                if($json)
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
                                <td><button class="btn btn-primary btn-sm" type="submit" name="action_account" value="edit my data">Change something</button></td>
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
                    ?>
                    <div class="card mb-3 mr-5 ml-5 text-center">
                        <div class="card-body">
                            <h1>Not found anything about you.</h1>
                        </div>
                    </div>
                    <?php
                }
                }

        if (isset($_GET['set_table']) && $_GET['set_table'] == 'Accounts') {?>

            <?php
            $json = @file_get_contents("http://localhost/bankB/api/constructor/readaccount.php?readMyAccounts=&id_user=".$id_user."");
            if($json){
                ?>

                <div class="card mb-3 mr-5 ml-5 text-center">
                    <div class="card-body">
                        <table class="table">
                            <thead>
                            <th>Account number</th>
                            <th>Balance</th>
                            <th colspan="4">Więcej</th>
                            </thead>
                            <tbody>

                <?php
                $arr = json_decode($json);
                foreach ($arr->Accounts as $key => $value)
                {

                    ?>
                    <form method='get'>
                        <tr>
                            <input type="hidden" value="<?php echo $value->id_account; ?>" name="id_check"/>

                            <?php $value->account_number; ?>
                            <td><?php echo readAccountNumber($value->account_number); ?></td>
                            <td><?php echo $value->balance." PLN"; ?></td>
                            <td><button class="btn btn-primary btn-sm" type="submit" name="show_details" value="info_about_account">Operations and payment</td>

                        </tr>
                    </form>
                    <?php } ?>
                        </tbody>
                        </table>
                    </div>
                    </div>
            <?php
            }else{
                ?>
                <div class="card mb-3 mr-5 ml-5 text-center">
                    <div class="card-body">
                        <h1>Not found accounts attached to you.</h1>
                    </div>
                </div>
                <?php
            }

        }?>

        <?php
        if (isset($_GET['show_details']) && $_GET['show_details'] == 'info_about_account'){
        ?>
        <?php
        $json = @file_get_contents("http://localhost/bankB/api/constructor/readoperation.php?readAboutAccount=&id_account=".$_GET['id_check']."");


        if($json){
        ?>
        <div class="container-fluid">
        <div class=" card mb-3 mr-5 ml-5 text-center">
            <div class=" card-body">
                <table class="table">
                    <thead>
                    <th> Sender's name </th>
                    <th> Sender's address </th>
                    <th> Sender Account </th>
                    <th> Recipent's name</th>
                    <th> Recipent's address</th>
                    <th> Recipent Account</th>
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
                        <td><?php echo $value->sender_name; ?></td>
                        <td><?php echo $value->sender_address; ?></td>
                        <td><?php echo readAccountNumber($value->sender_number); ?></td>
                        <td><?php echo $value->recipent_name; ?></td>
                        <td><?php echo $value->recipent_address; ?></td>
                        <td><?php echo readAccountNumber($value->recipent_number); ?></td>

                        <td><?php echo $value->title; ?></td>
                        <?php if(($value->status)=='completed' || ($value->status)=='sended'){
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
                    }else{?>
                            <div class="card mb-3 mr-5 ml-5 text-center">
                                  <div class="card-body">
                                         <h1>You not have any operations.</h1>
                                </div>
                            </div>
                <?php }
                $json = @file_get_contents("http://localhost/bankB/api/constructor/readaccount.php?readOneAccount=&id_account=".$_GET['id_check']."");
                if($json){
                    $arr = json_decode($json);
                    foreach ($arr->Accounts as $key => $value) {
                        ?>
                <div class=" mb-3 mr-5 ml-5 text-center">
                        <form method='get'>
                            <input type="hidden" value="<?php echo $value->id_account; ?>" name="id_account"/>
                            <button class="btn btn-primary" type="submit" name="action" value="do_payment">Do Payment</button>
                        </form>
                </div>
                        <?php
                    }

                } else
                {
                    ?>
                    <div class="card mb-3 mr-5 ml-5 text-center">
                        <div class="card-body">
                            <h1>You not have a operations.</h1>
                        </div>
                    </div>
                    <?php
                }}
                ?>
            </div>
        </div>
        </div>



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
        <div class="container-fluid pt-5">
            <div class="h-100 d-flex justify-content-center align-items-center">
                <div class="row smooth-scroll">
                    <div class="col-12 text-center">
                        <div class="card mb-3 mr-5 ml-5 text-center">
                                    <div class="card-body">
                            <form  method="get" action="http://localhost/bankB/api/constructor/readoperation.php?sent=" target="dummyframe" onsubmit="setTimeout(function(){location.replace('http://localhost/bankB/user.php');},10);">
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
                                    ?>
                                    <div class="card mb-3 mr-5 ml-5 text-center">
                                        <div class="card-body">
                                            <h1>You cann't do payment.</h1>
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
        }
        } else {
            echo "Nie znaleziono rekordów.";}
        }

        ?>



        <?php
        if (isset($_GET['action_account']) && $_GET['action_account'] == 'edit my data')
        {
            ?>

            <?php
            $json = @file_get_contents("http://localhost/bankB/api/constructor/readuser.php?readOne=&id=".$_GET['id']);

            if($json)
            {
                $arr = json_decode($json);
                foreach($arr->Users as $key => $value)
                {
                    ?>
                    <div class="container pt-5">
                        <div class="h-100 d-flex justify-content-center align-items-center">
                            <div class="row smooth-scroll col-7">
                                <div class="col-12 text-center">
                                    <div class="card mb-3 mr-5 ml-5 text-center">
                                        <div class="card-body">
                                            <form method="get" class="text-center" action="http://localhost/bankB/api/constructor/readuser.php?update=" target="dummyframe" onsubmit="setTimeout(function(){location.replace('http://localhost/bankB/user.php?set_table=Show+me');},10);">
                                                <input type="hidden" value="<?php echo $value->id; ?>" name="id"/>
                                                <input type="hidden" value="<?php echo $value->pesel; ?>"name="pesel" required/>
                                                <input type="hidden" value="<?php echo $value->type_user; ?>" name="type_user" required>
                                                <input type="hidden" value="<?php echo $value->username; ?>" name="username" required>
                                                <input type="hidden" value="<?php echo $value->password; ?>" name="password" required>
                                                <div class="form-group">
                                                    <h4><strong>Firstname: </strong></h4>
                                                    <input type="text" value="<?php echo $value->firstname; ?>"name="firstname" class="form-control" required>
                                                </div>
                                                <div class="form-group">
                                                    <h4><strong>Lastname: </strong></h4>
                                                    <input type="text" value="<?php echo $value->lastname; ?>"name="lastname" class="form-control" required>
                                                </div>
                                                <div class="form-group">
                                                    <h4><strong>Email: </strong></h4>
                                                    <input type="text" value="<?php echo $value->email; ?>"name="email" class="form-control" required>
                                                </div>
                                                <div class="form-group">
                                                    <h4><strong>Telephone: </strong></h4>
                                                    <input type="text" value="<?php echo $value->telephone; ?>" name="telephone" class="form-control" required>
                                                </div>
                                                <div class="form-group">
                                                    <h4><strong>Address: </strong></h4>
                                                    <input type="text" value="<?php echo $value->address; ?>" name="address"  class="form-control" required>
                                                </div>
                                                <button type="submit" name="update" value="update" class="btn btn-primary">Update</button>
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
                ?>
                <div class="card mb-3 mr-5 ml-5 text-center">
                    <div class="card-body">
                        <h1>Not found data.</h1>
                    </div>
                </div><?php

            }
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
    do {
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

?>