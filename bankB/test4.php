<?php

$url_download_token = 'https://jr-api-express.herokuapp.com/api/auth/login';
$data_download_token = array('username' => 'b105', 'password' => 'operator6');
$token=httpPost($url_download_token,$data_download_token);
$result = json_decode($token,true);
$token=$result['token'];
$_SESSION['fails_payment']=$token;







?>