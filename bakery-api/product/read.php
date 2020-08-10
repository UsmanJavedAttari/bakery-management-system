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
include_once '../models/product.php';

// initialize object
$product = new Product((new Database())->getConnection());

$search = isset($_GET["search"]) ? $_GET["search"] : "";
$productcategory = isset($_GET["productcategory"]) ? $_GET["productcategory"] : "";

// query products
$stmt = $product->read($search, $productcategory);
// products array
$products_arr = array();
// retrieve our table contents
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
  extract($row);
  $product_item = array(
    "Id" => $Id,
    "Title" => $Title,
    "Description" => html_entity_decode($Description),
    "Price" => $Price,
    "Quantity" => $Quantity,
    "ProductCategory" => $ProductCategory
  );
  array_push($products_arr, $product_item);
}
// set response code - 200 OK
http_response_code(200);
// show products data in json format
echo json_encode(
  array(
    "Message" => "",
    "Status" => true,
    "Data" => $products_arr
  )
);
