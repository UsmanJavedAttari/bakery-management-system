<?php
class ProductCategory {
  // Database connection and table name
  private $conn;
  private $table_name = "productcategory";
  
  // object properties
  public $Id;
  public $Title;
  public $Description;

  // Constructor with $db as database connection
  public function __construct($db) {
    $this->conn = $db;
  }

  public function read() {
    // Select all query
    $query = "SELECT * FROM {$this->table_name}";
    // Prepare query statement
    $stmt = $this->conn->prepare($query);
    // execute query
    $stmt->execute();
    return $stmt;
  }

  public function create(){
    // query to insert record
    $query = "INSERT INTO {$this->table_name} SET Id=:Id, Title=:Title, Description=:Description";

    // prepare query
    $stmt = $this->conn->prepare($query);
  
    // sanitize
    $this->Id=htmlspecialchars(strip_tags($this->Id));
    $this->Title=htmlspecialchars(strip_tags($this->Title));
    $this->Description=htmlspecialchars(strip_tags($this->Description));
  
    // bind values
    $stmt->bindParam(":Id", $this->Id);
    $stmt->bindParam(":Title", $this->Title);
    $stmt->bindParam(":Description", $this->Description);
  
    // execute query
    return $stmt->execute() ? true : false;     
  }
}
?>