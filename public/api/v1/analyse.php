<?include 'database.php';

function Listall($conn){
  $sql = "SELECT * FROM message";
  $result = $conn->query($sql);
  $res_array =  array();
  while($row = $result->fetch_assoc()) {
    array_push($res_array,$row);
  }
  return $res_array;
}

function currencyRequests($conn){
  //{"userId": "134256", "currencyFrom": "EUR", "currencyTo": "GBP", "amountSell": 1000, "amountBuy": 747.10, "rate": 0.7471, "timePlaced" : "24-JAN-15 10:27:44", "originatingCountry" : "FR"}

  $sql = "SELECT currencyFrom ,  currencyTo as convertion ,COUNT(*) as count FROM message GROUP BY currencyFrom, currencyTo ORDER BY count";
  $result = $conn->query($sql);
  $res_array =  array();
  while($row = $result->fetch_assoc()) {
    array_push($res_array,$row);
  }
  return $res_array;
}

echo json_encode (array('all' => Listall($conn),'currencyanalsis'=> currencyRequests($conn)));
?>
