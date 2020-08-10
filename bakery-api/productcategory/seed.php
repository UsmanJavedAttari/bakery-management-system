<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
  
// get database connection
include_once '../config/database.php';
include_once '../models/productcategory.php';
include_once '../utils/utils.php';

$productcategory = new ProductCategory((new Database())->getConnection());

$limit = isset($_GET['limit']) ? $_GET['limit'] : 10;

// set productcategory property values
for ($i = 0; $i < $limit; $i++) { 
  $productcategory->Id = guidv4();
  $productcategory->Title = randomString(10, 'Product Category ');
  $productcategory->Description = randomLipsum();
  $productcategory->create();
}

// set response code - 201 created
http_response_code(201);

// tell the user
echo json_encode(array("Message" => "Product Categories seeding done."));
?>