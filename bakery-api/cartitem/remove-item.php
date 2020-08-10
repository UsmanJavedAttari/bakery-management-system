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
include_once '../models/cartitem.php';
include_once '../models/cart.php';
include_once '../models/product.php';

$db = (new Database())->getConnection();
$cart = new Cart($db);
$cartitem = new CartItem($db);
$product = new Product($db);

$productId = $_GET['ProductId'];
$cartId = $_GET['CartId'];
if (
  !empty($productId) &&
  !empty($cartId)
) {
  // query productcategories
  $CartStmt = $cart->findById($cartId);
  $productStmt = $product->findById($productId);
  $CartItemStmt = $cartitem->itemExists($productId, $cartId);

  $isCartExists = $CartStmt->rowCount() < 1;
  $isProductExists = $productStmt->rowCount() < 1;
  $isCartItemExists = $CartItemStmt->rowCount() < 1;

  if ($isCartExists || $isProductExists || $isCartItemExists) {
    http_response_code(404);
    echo json_encode(array("Message" => "Cart or Product doesn't exist.", "Status" => false, "Data" => NULL));
    return;
  }

  if ($cartitem->delete($cartId, $productId)) {
    $product->Id = $productId;
    $product->Quantity = intval($productStmt->fetch(PDO::FETCH_ASSOC)['Quantity']) + intval($CartItemStmt->fetch(PDO::FETCH_ASSOC)['Quantity']);
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
      "Message" => "Unable to remove product from cart.",
      "Status" => false,
      "Data" => NULL,
    ));
    return;
  }

} else {
  http_response_code(400);
  echo json_encode(array("Message" => "One or more fields are missing.", "Status" => false, "Data" => NULL));
}
