<?php
session_start();
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Bank B</title>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.11.2/css/all.css">
    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <!-- Material Design Bootstrap -->
    <link href="css/mdb.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <style> html,
        body,
        header{
            height: 20%;

        }
    </style>
</head>
<body class="salon-lp tlo">
<main>
    <div class="container pt-5 mt-5 ">
        <div class=" mt-5 h-100 d-flex justify-content-center align-items-center mt-5">
            <div class="row smooth-scroll ">
                <div class="col-12 text-center mt-5">
                    <div class="text-black wow fadeInDown">
                        <div class="log pl-5 pb-4 pr-5 pt-2" style="background-color: rgba(255,255,255,0.5);">
                            <form method="get" action="login.php">
                                <div class="form-group">
                                    <h4><strong>Login: </strong></h4>
                                    <input type="text" name="username" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <h4><strong>Password: </strong></h4>
                                    <input type="password" name="password" class="form-control" required>

                                </div>
                                <button type="submit" class="btn btn-primary">Log in</button>
                            </form>
                            <?php
                            if (isset($_SESSION['failed_login'])){
                                echo $_SESSION['failed_login'];
                                unset($_SESSION['failed_login']);
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    </div>
</main>
<script type="text/javascript" src="js/jquery-3.4.1.min.js"></script>
<script type="text/javascript" src="js/popper.min.js"></script>
<script type="text/javascript" src="js/bootstrap.min.js"></script>
<script type="text/javascript" src="js/mdb.min.js"></script>
<script>
    new WOW().init();
    $(function () {
        $("#mdb-lightbox-ui").load("/mdb-addons/mdb-lightbox-ui.html");
    });
</script>
</body>
</html>
