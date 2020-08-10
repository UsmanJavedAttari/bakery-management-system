<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: DELETE");
header("Access-Control-Allow-Headers: Content-Type, Accept");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {    
  http_response_code(200);
  return;   
}

// include database and object files
include_once '../config/database.php';
include_once '../utils/utils.php';
include_once '../models/paymentaccount.php';

$paymentaccount = new PaymentAccount((new Database())->getConnection());

$data = json_decode(file_get_contents("php://input"));
if (
  !empty($data->PaymentCardNumber) &&
  !empty($data->CustomerId)
) {
  $paymentaccount->PaymentCardNumber = $data->PaymentCardNumber;
  $paymentaccount->CustomerId = $data->CustomerId;
  if ($paymentaccount->create()) {
    http_response_code(200);
    echo json_encode(array(
      "Message" => "",
      "Status" => true,
      "Data" => NULL,
    ));
    return;
  } else {
    http_response_code(409);
    echo json_encode(array(
      "Message" => "Payment Account already exists.",
      "Status" => false,
      "Data" => NULL,
    ));
    return;
  }

} else {
  http_response_code(400);
  echo json_encode(array("Message" => "One or more fields are missing.", "Status" => false, "Data" => NULL));
}
