<?php
function readAccountNumber($odzial)
{

    $first=$odzial;
    $check="PL  ";
    $first1=substr($first,0,2);
    $check=$check.$first1." ";
    $first1=substr($first,2,4);
    $check=$check.$first1." ";
    $first1=substr($first,6,4);
    $check=$check.$first1." ";
    $first1=substr($first,10,4);
    $check=$check.$first1." ";
    $first1=substr($first,14,4);
    $check=$check.$first1." ";
    $first1=substr($first,18,4);
    $check=$check.$first1." ";
    $first1=substr($first,22,4);
    $check=$check.$first1;

   return $check;
}
echo readAccountNumber('98105044756899686176917854');
?>


