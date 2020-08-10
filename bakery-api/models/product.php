<?php
class Product {
  // Database connection and table name
  private $conn;
  private $table_name = "product";
  
  // object properties
  public $Id;
  public $Title;
  public $Description;
  public $Price;
  public $Quantity;
  public $ProductCategoryId;

  // Constructor with $db as database connection
  public function __construct($db) {
    $this->conn = $db;
  }

  public function read($search = '', $productcategory = '') {
    // Select all query
    $query = "SELECT
                pro.Id, pro.Title, pro.Description, pro.Price, pro.Quantity, pro_c.Title as ProductCategory
              FROM {$this->table_name} AS pro
              JOIN productcategory AS pro_c ON pro.ProductCategoryId = pro_c.Id
              WHERE
                pro.Title LIKE ? AND pro.ProductCategoryId LIKE ? AND Quantity > 0
              ";
    // Prepare query statement
    $stmt = $this->conn->prepare($query);

    // sanitize
    $search = htmlspecialchars(strip_tags($search));
    $search = "%{$search}%";
    $ProductCategoryId = htmlspecialchars(strip_tags($productcategory));
    $ProductCategoryId = "%{$ProductCategoryId}%";

    // bind
    $stmt->bindParam(1, $search);
    $stmt->bindParam(2, $ProductCategoryId);

    // execute query
    $stmt->execute();
    return $stmt;
  }

  public function findById($productId) {
    // Select all query
    $query = "SELECT * FROM {$this->table_name} WHERE Id = ?";
    // Prepare query statement
    $stmt = $this->conn->prepare($query);

    //sanitize
    $this->Id=htmlspecialchars(strip_tags($productId));

    // bind values
    $stmt->bindParam("1", $this->Id);

    // execute query
    $stmt->execute();
    return $stmt;
  }

  public function create(){
    // query to insert record
    $query = "INSERT INTO {$this->table_name} SET 
              Id=:Id, Title=:Title, Price=:Price, Description=:Description, ProductCategoryId=:ProductCategoryId, Quantity=:Quantity";

    // prepare query
    $stmt = $this->conn->prepare($query);
  
    // sanitize
    $this->Id=htmlspecialchars(strip_tags($this->Id));
    $this->Title=htmlspecialchars(strip_tags($this->Title));
    $this->Price=htmlspecialchars(strip_tags($this->Price));
    $this->Description=htmlspecialchars(strip_tags($this->Description));
    $this->ProductCategoryId=htmlspecialchars(strip_tags($this->ProductCategoryId));
    $this->Quantity=htmlspecialchars(strip_tags($this->Quantity));
  
    // bind values
    $stmt->bindParam(":Id", $this->Id);
    $stmt->bindParam(":Title", $this->Title);
    $stmt->bindParam(":Price", $this->Price);
    $stmt->bindParam(":Description", $this->Description);
    $stmt->bindParam(":ProductCategoryId", $this->ProductCategoryId);
    $stmt->bindParam(":Quantity", $this->Quantity);
  
    // execute query
    return $stmt->execute() ? true : false;     
  }

  public function updateQuantity() {
    // query to insert record
    $query = "UPDATE {$this->table_name} SET Quantity=:Quantity WHERE Id=:Id";

    // prepare query
    $stmt = $this->conn->prepare($query);
  
    // sanitize
    $this->Id=htmlspecialchars(strip_tags($this->Id));
    $this->Quantity=htmlspecialchars(strip_tags($this->Quantity));
    $this->Quantity = intval($this->Quantity) < 0 ? 0 : $this->Quantity;
  
    // bind values
    $stmt->bindParam(":Id", $this->Id);
    $stmt->bindParam(":Quantity", $this->Quantity);
  
    // execute query
    return $stmt->execute() ? true : false;     
  }
}
?>