<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: UPDATE");
header("Access-Control-Allow-Headers: Content-Type, Accept");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {    
  http_response_code(200);
  return;   
}

// include database and object files
include_once '../config/database.php';
include_once '../models/customer.php';

$customer = new Customer((new Database())->getConnection());

$data = json_decode(file_get_contents("php://input"));

if (
  !empty($data->DisplayName) &&
  !empty($data->Id)
) {
  // query productcategories
  $customerStmt = $customer->findById($data->Id);

  if ($customerStmt->rowCount() < 1) {
    http_response_code(404);
    echo json_encode(array("Message" => "User doesn't exist.", "Status" => false, "Data" => NULL));
    return;
  }

  $customer->DisplayName = $data->DisplayName;
  if (!empty($data->Password)) {
    $customer->Password = $data->Password;
  }
  if ($customer->update()) {
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
      "Message" => "Unable to update user profile.",
      "Status" => false,
      "Data" => NULL,
    ));
    return;
  }

} else {
  http_response_code(400);
  echo json_encode(array("Message" => "Display Name must not be empty.", "Status" => false, "Data" => NULL));
}
