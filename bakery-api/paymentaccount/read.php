<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type, Accept");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {    
  http_response_code(200);
  return;   
}

// include database and object files
include_once '../config/database.php';
include_once '../models/paymentaccount.php';

// initialize object
$paymentaccount = new PaymentAccount((new Database())->getConnection());

if (isset($_GET["CustomerId"])) {
  // query paymentaccounts
  $paymentaccount->CustomerId = $_GET["CustomerId"];
  $stmt = $paymentaccount->read();
  $paymentaccounts_arr = array();
  // retrieve our table contents
  while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
    extract($row);
    $paymentaccount_item = array(
      "PaymentCardNumber" => $PaymentCardNumber,
      "CustomerId" => $CustomerId,
    );
    array_push($paymentaccounts_arr, $paymentaccount_item);
  }
  // set response code - 200 OK
  http_response_code(200);
  // show paymentaccounts data in json format
  echo json_encode(
    array(
      "Message" => "",
      "Status" => true,
      "Data" => $paymentaccounts_arr
    )
  );
} else {
  http_response_code(400);
  // show carts data in json format
  echo json_encode(
    array(
      "Message" => "Customer Id is empty.",
      "Status" => false,
      "Data" => NULL
    )
  );
}
