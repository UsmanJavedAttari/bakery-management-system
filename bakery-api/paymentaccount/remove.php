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

$paymentCardNumber = $_GET['PaymentCardNumber'];
if (
  !empty($paymentCardNumber)
) {
  // query productcategories
  $paymentAccountStmt = $paymentaccount->findById($paymentCardNumber);

  if ($paymentAccountStmt->rowCount() < 1) {
    http_response_code(404);
    echo json_encode(array("Message" => "Payment Account doesn't exist.", "Status" => false, "Data" => NULL));
    return;
  }

  if ($paymentaccount->delete($paymentCardNumber)) {
    http_response_code(200);
    echo json_encode(array(
      "Message" => "",
      "Status" => true,
      "Data" => NULL,
    ));
    return;
  } else {
    http_response_code(503);
    echo json_encode(array(
      "Message" => "Unable to remove Payment Card Number.",
      "Status" => false,
      "Data" => NULL,
    ));
    return;
  }

} else {
  http_response_code(400);
  echo json_encode(array("Message" => "Payment Card Number is missing.", "Status" => false, "Data" => NULL));
}
