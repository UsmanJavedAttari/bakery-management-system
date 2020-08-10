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
include_once '../models/paymentaccount.php';
include_once '../models/order.php';
include_once '../models/orderdetail.php';
include_once '../models/paymentinvoice.php';

$db = (new Database())->getConnection();
$cart = new Cart($db);
$cartitem = new CartItem($db);
$product = new Product($db);
$paymentaccount = new PaymentAccount($db);
$order = new Order($db);
$orderdetail = new OrderDetail($db);
$paymentinvoice = new PaymentInvoice($db);

$data = json_decode(file_get_contents("php://input"));

if (
  !empty($data->PaymentCardNumber) &&
  !empty($data->CustomerId)
) {
  $cartStmt = $cart->findByCustomerId($data->CustomerId);
  $Cart = $cartStmt->fetch(PDO::FETCH_ASSOC);
  $paymentaccountStmt = $paymentaccount->findById($data->PaymentCardNumber);
  $cartItemStmt = $cartitem->findAllByCartId($Cart['Id']);

  if ($paymentaccountStmt->rowCount() < 1 || $cartStmt->rowCount() < 1 || $cartItemStmt->rowCount() < 1) {
    http_response_code(404);
    echo json_encode(array("Message" => "Please select payment account.", "Status" => false, "Data" => NULL));
    return;
  }

  $done = false;
  $order->Id = guidv4();
  $order->CustomerId = $data->CustomerId;
  if ($order->create()) {
    while ($row = $cartItemStmt->fetch(PDO::FETCH_ASSOC)){
      extract($row);

      $productStmt = $product->findById($ProductId);

      $orderdetail->Id = guidv4();
      $orderdetail->OrderId = $order->Id;
      $orderdetail->ProductId = $ProductId;
      $orderdetail->UnitPrice = $productStmt->fetch(PDO::FETCH_ASSOC)['Price'];
      $orderdetail->Quantity = $Quantity;
      if (!$orderdetail->create()) {
        break;
      }
    }
    $totalAmountStmt = $cartitem->calculateTotalAmount($Cart['Id']);
    $totalAmount = ($totalAmountStmt->fetch(PDO::FETCH_ASSOC))['TotalAmount'];
    if ($cartitem->deleteAll($Cart['Id'])) {
  
      $paymentinvoice->Id = guidv4();
      $paymentinvoice->PaymentCardNumber = $data->PaymentCardNumber;
      $paymentinvoice->OrderId = $order->Id;
      $paymentinvoice->AmountCharged = $totalAmount;
      if ($paymentinvoice->create()) {
        $done = true;
      }
    }
  }

  if ($done) {
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
      "Message" => "Unable create payment invoice.",
      "Status" => false,
      "Data" => NULL,
    ));
    return;
  }

} else {
  http_response_code(400);
  echo json_encode(array("Message" => "One or more fields are missing.", "Status" => false, "Data" => NULL));
}
