<?php
class Cart {
  // Database connection and table name
  private $conn;
  private $table_name = "cart";
  
  // object properties
  public $Id;
  public $CustomerId;

  // Constructor with $db as database connection
  public function __construct($db) {
    $this->conn = $db;
  }

  public function findById($cartId) {
    // Select all query
    $query = "SELECT * FROM {$this->table_name} WHERE Id = ?";
    // Prepare query statement
    $stmt = $this->conn->prepare($query);

    //sanitize
    $this->Id=htmlspecialchars(strip_tags($cartId));

    // bind values
    $stmt->bindParam("1", $this->Id);

    // execute query
    $stmt->execute();
    return $stmt;
  }

  public function findByCustomerId($customerId) {
    // Select all query
    $query = "SELECT * FROM {$this->table_name} WHERE CustomerId = ?";
    // Prepare query statement
    $stmt = $this->conn->prepare($query);

    //sanitize
    $this->Id=htmlspecialchars(strip_tags($customerId));

    // bind values
    $stmt->bindParam("1", $this->Id);

    // execute query
    $stmt->execute();
    return $stmt;
  }

  public function getTotalNumberOfItems($customerId) {
    // Get item count
    $query = "SELECT
                (SELECT COUNT(*) as ItemCount FROM cartitem WHERE cartitem.CartId = c.Id) AS NumberOfItems
              FROM `cart` AS c WHERE CustomerId = ?";
    // Prepare query statement
    $stmt = $this->conn->prepare($query);

    //sanitize
    $this->CustomerId=htmlspecialchars(strip_tags($customerId));

    // bind values
    $stmt->bindParam("1", $this->CustomerId);

    // execute query
    $stmt->execute();
    return $stmt;
  }

  public function create() {
    // query to insert record
    $query = "INSERT INTO {$this->table_name} SET Id=:Id, CustomerId=:CustomerId";

    // prepare query
    $stmt = $this->conn->prepare($query);
  
    // sanitize
    $this->Id=htmlspecialchars(strip_tags($this->Id));
    $this->CustomerId=htmlspecialchars(strip_tags($this->CustomerId));
  
    // bind values
    $stmt->bindParam(":Id", $this->Id);
    $stmt->bindParam(":CustomerId", $this->CustomerId);
  
    // execute query
    return $stmt->execute() ? true : false;     
  }
}
?>