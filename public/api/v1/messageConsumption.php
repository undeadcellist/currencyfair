<?php
include 'database.php';
error_reporting(E_ALL & ~E_DEPRECATED);
$postdata = file_get_contents("php://input");
$request = json_decode($postdata);
//limied to 5 adds in a 3 min
function ratelimit($userid,$conn){
  $sql="SELECT COUNT(userId) AS total FROM message AS m WHERE m.userId = $userid AND m.timePlaced >= now() - interval 5 minute";

     $result = $conn->query($sql);

    $total=$result->fetch_assoc()['total'];
     if ($total<=5){
       return true;
     }else{
       return false;
     }
}


if( ratelimit($request->userId,$conn) ){
  $timestamp = strtotime($request->timePlaced);
  $creationDate = date("Y:m-d G:i:s", $timestamp);
  $sql="INSERT INTO message (userId, currencyFrom, currencyTo, amountSell, amountBuy, rate,timePlaced,originatingCountry)
  VALUES ('$request->userId','$request->currencyFrom','$request->currencyTo','$request->amountSell','$request->amountBuy','$request->rate','$creationDate','$request->originatingCountry');  ";
  echo $sql;
  if ($conn->query($sql) === TRUE) {
    echo "ok";
  } else {
    echo "Error creating table: " . $conn->error;
  }
}


//echo $sql;
//{"userId": "134256", "currencyFrom": "EUR", "currencyTo": "GBP", "amountSell": 1000, "amountBuy": 747.10, "rate": 0.7471, "timePlaced" : "24-JAN-15 10:27:44", "originatingCountry" : "FR"}
?>
