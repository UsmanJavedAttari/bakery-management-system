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
include_once '../models/cartitem.php';

// initialize object
$cartitem = new CartItem((new Database())->getConnection());

if (isset($_GET["CartId"])) {
  // query cartitems
  $stmt = $cartitem->calculateTotalAmount($_GET["CartId"]);
  $totalAmount = $stmt->fetch(PDO::FETCH_ASSOC);

  // set response code - 200 OK
  http_response_code(200);
  // show cartitems data in json format
  echo json_encode(
    array(
      "Message" => "",
      "Status" => true,
      "Data" => !empty($totalAmount['TotalAmount']) ? $totalAmount['TotalAmount'] : 0
    )
  );
  
} else {
  http_response_code(400);
  // show cartitems data in json format
  echo json_encode(
    array(
      "Message" => "Cart Id is empty",
      "Status" => false,
      "Data" => NULL
    )
  );
}