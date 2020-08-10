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
include_once '../models/cartitem.php';
include_once '../models/product.php';

$db = (new Database())->getConnection();
$cart = new Cart($db);
$cartitem = new CartItem($db);
$product = new Product($db);

if (isset($_GET["customerId"])) {
  // query carts
  $cartStmt = $cart->findByCustomerId($_GET["customerId"]);
  $customerCart = $cartStmt->fetch(PDO::FETCH_ASSOC);

  if ($customerCart) {
    extract($customerCart);
    // Get Cart Items using cartId
    $cartItemsStmt = $cartitem->findAllByCartId($Id);
    $customerCartItems = array();
    // retrieve our table contents
    while ($cartItems = $cartItemsStmt->fetch(PDO::FETCH_ASSOC)){
      extract($cartItems);

      // Get Product using CartItem->ProductId
      $productStmt = $product->findById($ProductId);
      $cartItemProduct = $productStmt->fetch(PDO::FETCH_ASSOC);

      $cartItem = array(
        "Id" => $Id,
        "CartId" => $CartId,
        "ProductId" => $ProductId,
        "Quantity" => $Quantity,
        "TotalCost" => $TotalCost,
        "Product" => $cartItemProduct
      );
      array_push($customerCartItems, $cartItem);
    }

    // set response code - 200 OK
    http_response_code(200);
    // show carts data in json format
    echo json_encode(
      array(
        "Message" => "",
        "Status" => true,
        "Data" => $customerCartItems
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