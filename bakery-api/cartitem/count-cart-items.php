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
include_once '../models/cart.php';

// initialize object
$cart = new Cart((new Database())->getConnection());

if (isset($_GET["customerId"])) {
  // query carts
  $stmt = $cart->getTotalNumberOfItems($_GET["customerId"]);
  $totalItems = $stmt->fetch(PDO::FETCH_ASSOC);

  if ($totalItems) {
    // set response code - 200 OK
    http_response_code(200);
    // show carts data in json format
    echo json_encode(
      array(
        "Message" => "",
        "Status" => true,
        "Data" => $totalItems
      )
    );
  } else {
    http_response_code(404);
    // show carts data in json format
    echo json_encode(
      array(
        "Message" => "No cart found for this customer",
        "Status" => false,
        "Data" => NULL
      )
    );
  }
  
} else {
  http_response_code(400);
  // show carts data in json format
  echo json_encode(
    array(
      "Message" => "Customer Id is empty",
      "Status" => false,
      "Data" => NULL
    )
  );
}