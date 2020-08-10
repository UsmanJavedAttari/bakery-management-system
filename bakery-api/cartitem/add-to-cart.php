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
include_once '../utils/utils.php';
include_once '../models/cartitem.php';
include_once '../models/cart.php';
include_once '../models/product.php';

$db = (new Database())->getConnection();
$cart = new Cart($db);
$cartitem = new CartItem($db);
$product = new Product($db);

$data = json_decode(file_get_contents("php://input"));

if (
  !empty($data->ProductId) &&
  !empty($data->CartId)
) {
  // query productcategories
  $CartStmt = $cart->findById($data->CartId);
  $productStmt = $product->findById($data->ProductId);

  $Product = $productStmt->fetch(PDO::FETCH_ASSOC);


  // var_dump(intval($Product['Quantity']) < 1);
  $isCartExists = $CartStmt->rowCount() < 1;
  $isProductExists = $productStmt->rowCount() < 1;
  if ($isCartExists || $isProductExists || (intval($Product['Quantity']) < 1 && !$data->Dec)) {
    http_response_code(404);
    echo json_encode(array("Message" => "Product out of stock.", "Status" => false, "Data" => NULL));
    return;
  }

  $cartItemStmt = $cartitem->itemExists($data->ProductId, $data->CartId);
  $isItemExists = $cartItemStmt->fetch(PDO::FETCH_ASSOC);

  $done = false;
  $product->Quantity = intval($Product['Quantity']);
  $cartitem->ProductId = $data->ProductId;
  $cartitem->CartId = $data->CartId;
  if ($isItemExists) {
    if ($data->Dec) {
      if (!(intval($isItemExists['Quantity']) <= 1)) {
        $cartitem->Quantity = intval($isItemExists['Quantity']) - 1;
        $product->Quantity = intval($Product['Quantity']) + 1;
      }
    } else {
      $cartitem->Quantity = intval($isItemExists['Quantity']) + 1;
      $product->Quantity = intval($Product['Quantity']) - 1;
    }
    if ($cartitem->updateQuantity()) {
      $done = true;
    }
  } else {
    $product->Quantity = intval($Product['Quantity']) - 1;
    $cartitem->Quantity = 1;
    if ($cartitem->create()) {
      $done = true;
    }
  }
  if ($done) {
    $product->Id = $data->ProductId;
    $product->updateQuantity();
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
      "Message" => "Unable to add product into cart.",
      "Status" => false,
      "Data" => NULL,
    ));
    return;
  }

} else {
  http_response_code(400);
  echo json_encode(array("Message" => "One or more fields are missing.", "Status" => false, "Data" => NULL));
}
