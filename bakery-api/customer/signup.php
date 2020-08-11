<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type, Accept");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {    
  http_response_code(200);
  return;   
}
  
// get database connection
include_once '../config/database.php';
include_once '../models/customer.php';
include_once '../models/paymentaccount.php';
include_once '../models/cart.php';
include_once '../utils/utils.php';

$db = (new Database())->getConnection();
$customer = new Customer($db);
$paymentaccount = new PaymentAccount($db);
$cart = new Cart($db);

$data = json_decode(file_get_contents("php://input"));

if (
  !empty($data->DisplayName) &&
  !empty($data->Email) &&
  !empty($data->Password) &&
  !empty($data->PaymentCardNumber)
) {
  $customer->Id = guidv4();
  $paymentaccount->PaymentCardNumber = $data->PaymentCardNumber;
  $paymentaccount->CustomerId = $customer->Id;
  $customer->DisplayName = $data->DisplayName;
  $customer->Email = $data->Email;
  $customer->Password = $data->Password;
  if ($customer->create()) {
    if ($paymentaccount->create()) {
      $cart->Id = guidv4();
      $cart->NumberOfItems = 0;
      $cart->TotalCost = 0;
      $cart->CustomerId = $customer->Id;
      if ($cart->create()) {
        http_response_code(201);
        echo json_encode(array("Message" => "Customer created successfully.", "Status" => true, "Data" => NULL));
        return;
      } else {
        $paymentaccount->delete($paymentaccount->PaymentCardNumber);
        $customer->delete($customer->Id);
        http_response_code(503);
        echo json_encode(array("Message" => "Unable to create customer.", "Status" => false, "Data" => NULL));
        return;
      }
    } else {
      $customer->delete($customer->Id);
      http_response_code(409);
        echo json_encode(array("Message" => "Payment account already exists.", "Status" => false, "Data" => NULL));
      return;
    }
  } else {
    http_response_code(409);
    echo json_encode(array("Message" => "Email already exists.", "Status" => false, "Data" => NULL));
    return;
  }
} else {
  http_response_code(400);
  echo json_encode(array("Message" => "One or more fields are missing.", "Status" => false, "Data" => NULL));
  return;
}
?>