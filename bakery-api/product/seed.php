<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
  
// get database connection
include_once '../config/database.php';
  
// instantiate product object
include_once '../models/product.php';
include_once '../models/productcategory.php';
include_once '../utils/utils.php';

$db = (new Database())->getConnection();

$product = new Product($db);
$productcategory = new ProductCategory($db);

$stmt = $productcategory->read();
$num = $stmt->rowCount();

$productcategory_ids = array();

while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
  extract($row);
  array_push($productcategory_ids, $Id);
}

$limit = isset($_GET['limit']) ? $_GET['limit'] : 10;

// set product property values
for ($i = 0; $i < $limit; $i++) { 
  $product->Id = guidv4();
  $product->Title = randomString(10, 'Product ');
  $product->Price = randomNumber();
  $product->Description = randomLipsum();
  $product->Quantity = randomNumber();
  $product->ProductCategoryId = $productcategory_ids[array_rand($productcategory_ids)];
  $product->create();
}

// set response code - 201 created
http_response_code(201);

// tell the user
echo json_encode(array("Message" => "Products seeding done."));
?>