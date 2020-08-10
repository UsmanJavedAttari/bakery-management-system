<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type, Accept");
header("Content-Type: application/json");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
  http_response_code(200);
  return;   
}

// include database and object files
include_once '../config/database.php';
include_once '../models/order.php';
include_once '../models/orderdetail.php';
include_once '../models/product.php';
include_once '../models/paymentinvoice.php';

$db = (new Database())->getConnection();
$order = new Order($db);
$orderdetail = new OrderDetail($db);
$product = new Product($db);
$paymentinvoice = new PaymentInvoice($db);

if (isset($_GET["customerId"])) {
  // query orders
  $orderStmt = $order->findByCustomerId($_GET["customerId"]);

  $paymentInvoices = array();
  while ($customerOrder = $orderStmt->fetch(PDO::FETCH_ASSOC)) {
    extract($customerOrder);
    // Get Order Items using orderId
    $orderDetailsStmt = $orderdetail->findAllByOrderId($Id);
    $paymentinvoiceStmt = $paymentinvoice->findByOrderId($Id);
    $customerOrderDetails = array();
    // retrieve our table contents
    while ($orderDetails = $orderDetailsStmt->fetch(PDO::FETCH_ASSOC)){
      extract($orderDetails);
  
      // Get Product using OrderDetail->ProductId
      $productStmt = $product->findById($ProductId);
      $orderDetailProduct = $productStmt->fetch(PDO::FETCH_ASSOC);
  
      $orderDetail = array(
        "Id" => $Id,
        "OrderId" => $OrderId,
        "ProductId" => $ProductId,
        "Quantity" => $Quantity,
        "TotalCost" => $TotalCost,
        "UnitPrice" => $UnitPrice,
        "Product" => $orderDetailProduct
      );
      array_push($customerOrderDetails, $orderDetail);
    }

    $paymentInvoice = $paymentinvoiceStmt->fetch(PDO::FETCH_ASSOC);
    extract($paymentInvoice);
    $paymentInvoiceItem = array(
      "Id" => $ShortId,
      "OrderId" => $OrderId,
      "AmountCharged" => $AmountCharged,
      "PaymentCardNumber" => $PaymentCardNumber,
      "GeneratedAt" => $GeneratedAt,
      "OrderDetails" => $customerOrderDetails
    );
    array_push($paymentInvoices, $paymentInvoiceItem);
  }

  // set response code - 200 OK
  http_response_code(200);
  // show orders data in json format
  echo json_encode(
    array(
      "Message" => "",
      "Status" => true,
      "Data" => $paymentInvoices
    )
  );
  
} else {
  http_response_code(400);
  // show orders data in json format
  echo json_encode(
    array(
      "Message" => "Customer Id is empty",
      "Status" => false,
      "Data" => NULL
    )
  );
}