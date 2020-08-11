<?php
class Order {
  // Database connection and table name
  private $conn;
  private $table_name = "order";
  
  // object properties
  public $Id;
  public $CustomerId;
  public $CreatedAt;

  // Constructor with $db as database connection
  public function __construct($db) {
    $this->conn = $db;
  }

  public function findByCustomerId($customerId) {
    $query = "SELECT * FROM `{$this->table_name}` WHERE CustomerId = ? ORDER BY CreatedAt DESC";
    // Prepare query statement
    $stmt = $this->conn->prepare($query);

    // sanitize
    $this->CustomerId=htmlspecialchars(strip_tags($customerId));
  
    // bind values
    $stmt->bindParam("1", $this->CustomerId);
    $stmt->execute();
    return $stmt;
  }

  public function read() {
    // Select all query
    $query = "SELECT * FROM {$this->table_name} WHERE CustomerId = ? ORDER BY CreatedAt DESC";
    // Prepare query statement
    $stmt = $this->conn->prepare($query);
    
    // sanitize
    $this->CustomerId=htmlspecialchars(strip_tags($this->CustomerId));
  
    // bind id of record to delete
    $stmt->bindParam(1, $this->CustomerId);

    // execute query
    $stmt->execute();
    return $stmt;
  }

  public function create() {
    // query to insert record
    $query = "INSERT INTO `{$this->table_name}` SET Id=:Id, CustomerId=:CustomerId, CreatedAt=:CreatedAt";

    // prepare query
    $stmt = $this->conn->prepare($query);
  
    // sanitize
    $this->Id=htmlspecialchars(strip_tags($this->Id));
    $this->CustomerId=htmlspecialchars(strip_tags($this->CustomerId));
    $this->CreatedAt = (new DateTime('now', new DateTimeZone('Asia/Karachi')))->format('Y-m-d H:i:s');
    // bind values
    $stmt->bindParam(":Id", $this->Id);
    $stmt->bindParam(":CustomerId", $this->CustomerId);
    $stmt->bindParam(":CreatedAt", $this->CreatedAt);
  
    // execute query
    return $stmt->execute() ? true : false;     
  }
}
?>