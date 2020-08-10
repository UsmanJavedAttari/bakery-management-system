<?php
class PaymentAccount {
  // Database connection and table name
  private $conn;
  private $table_name = "paymentaccount";
  
  // object properties
  public $PaymentCardNumber;
  public $CustomerId;

  // Constructor with $db as database connection
  public function __construct($db) {
    $this->conn = $db;
  }

  public function findById($paymentCardNumber) {
    $query = "SELECT * FROM {$this->table_name} WHERE PaymentCardNumber = ?";
    // Prepare query statement
    $stmt = $this->conn->prepare($query);

    // sanitize
    $this->PaymentCardNumber=htmlspecialchars(strip_tags($paymentCardNumber));
  
    // bind values
    $stmt->bindParam("1", $this->PaymentCardNumber);
    $stmt->execute();
    return $stmt;
  }

  public function read() {
    // Select all query
    $query = "SELECT * FROM {$this->table_name} WHERE CustomerId = ?";
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

  public function delete($paymentCardNumber) {
    // delete query
    $query = "DELETE FROM {$this->table_name} WHERE PaymentCardNumber = ?";
  
    // prepare query
    $stmt = $this->conn->prepare($query);
  
    // sanitize
    $this->PaymentCardNumber=htmlspecialchars(strip_tags($paymentCardNumber));
  
    // bind paymentCardNumber of record to delete
    $stmt->bindParam(1, $this->PaymentCardNumber);
  
    // execute query
    return $stmt->execute() ? true : false;
  }

  public function create() {
    // query to insert record
    $query = "INSERT INTO {$this->table_name} SET PaymentCardNumber=:PaymentCardNumber, CustomerId=:CustomerId";

    // prepare query
    $stmt = $this->conn->prepare($query);
  
    // sanitize
    $this->PaymentCardNumber=htmlspecialchars(strip_tags($this->PaymentCardNumber));
    $this->CustomerId=htmlspecialchars(strip_tags($this->CustomerId));
  
    // bind values
    $stmt->bindParam(":PaymentCardNumber", $this->PaymentCardNumber);
    $stmt->bindParam(":CustomerId", $this->CustomerId);
  
    // execute query
    return $stmt->execute() ? true : false;     
  }
}
?>