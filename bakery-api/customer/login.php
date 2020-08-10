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
include_once '../models/customer.php';
include_once '../models/cart.php';
include_once '../models/cartitem.php';
include_once '../models/product.php';

$db = (new Database())->getConnection();
$customer = new Customer($db);
$cart = new Cart($db);
$cartitem = new CartItem($db);
$product = new Product($db);

$data = json_decode(file_get_contents("php://input"));

if (
  !empty($data->Email) &&
  !empty($data->Password)
) {
  // query productcategories
  $stmt = $customer->findByEmail($data->Email);

  $num = $stmt->rowCount();

  if ($num < 1) {
    http_response_code(401);
    echo json_encode(array("Message" => "Email is wrong.", "Status" => false, "Data" => NULL));
    return;
  }

  $customer = $stmt->fetch(PDO::FETCH_ASSOC);
  extract($customer);

  if (!password_verify($data->Password, $Password)) {
    http_response_code(401);
    echo json_encode(array("Message" => "Password is wrong.", "Status" => false, "Data" => NULL));
    return;
  } else {
    // Get Cart
    $cartStmt = $cart->findByCustomerId($Id);
    $customerCart = $cartStmt->fetch(PDO::FETCH_ASSOC);

    http_response_code(200);
    echo json_encode(array(
      "Message" => "Success",
      "Status" => true,
      "Data" => array(
        "Id" => $Id,
        "DisplayName" => $DisplayName,
        "Email" => $Email,
        "CartId" => $customerCart['Id']
      ),
    ));
  }
} else {
  http_response_code(400);
  echo json_encode(array("Message" => "Email or Password missing.", "Status" => false, "Data" => NULL));
}
