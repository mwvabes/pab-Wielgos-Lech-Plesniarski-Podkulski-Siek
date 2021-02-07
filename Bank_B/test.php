<?php
/*
//105 0447
$number_of_bank="194";
$number_of_oddial="0107";
$test=$number_of_bank.$number_of_oddial;
$array=array(3,9,7,1,3,9,7);
$array1=array(3,9,7,1,3,9,7,1);
$testing=0;
$testing2=0;

echo "tak: ".$test."<br/>";
for ($i = 0; $i < strlen($test); $i++) {

    $testing=$testing+($array[$i]*(int)substr($test,$i,1));
   // echo "Iteracja: ".$i."  słowko: ".substr($test,$i,1)."<br/>";
}
//echo "bla bla bla Iteracja:   słowko: ".substr($test,1,1)."<br/>";
$temp=$testing;
$temp=$temp%10;
$testing=10-$temp;

echo $testing."<br/>";

$test=$test.$testing;
echo $test."<br/>";
for ($i = 0; $i < strlen($test); $i++) {

    $testing2=$testing2+($array1[$i]*(int)substr($test,$i,1));
    // echo "Iteracja: ".$i."  słowko: ".substr($test,$i,1)."<br/>";
}
echo $testing2."<br/>";
$testing2=$testing2%10;
if($testing2=="0"){
    echo "Poprawny";
}else{
    echo "NiePoprawny";
}
*/
function getTypeOfSend1($odzial)
{

    $first=$odzial;
    $first1 = substr($first, 2, 3);

    if($first1==105){
        return 1;

    }else{
        return 0;
    }

}

function getRecipmentId2($recipment_number){
    $query = "SELECT id_account,account_number FROM account  WHERE account_number = '$recipment_number'";
    $stmt = $this->connection->prepare($query);
    $result = $stmt->get_result();
    if($result->num_rows == 1) {     // <--- change to $result->...!
        while ($data = $result->fetch_assoc()) {
            return $data['id_account']." ".$data['account_number'];  // <--- available in $data

        }
    }
}


echo getRecipmentId2('98102044754123564553454267');

?>