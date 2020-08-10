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
include_once '../models/productcategory.php';

// initialize object
$productcategory = new ProductCategory((new Database())->getConnection());

// query productcategories
$stmt = $productcategory->read();
$num = $stmt->rowCount();
// productcategories array
$productcategories_arr = array();
// retrieve our table contents
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
  extract($row);
  $productcategory_item = array(
    "Id" => $Id,
    "Title" => $Title,
    "Description" => html_entity_decode($Description),
  );
  array_push($productcategories_arr, $productcategory_item);
}
// set response code - 200 OK
http_response_code(200);
// show productcategories data in json format
echo json_encode(
  array(
    "Message" => "",
    "Status" => true,
    "Data" => $productcategories_arr
  )
);
