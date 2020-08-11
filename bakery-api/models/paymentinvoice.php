<?php
class PaymentInvoice {
  // Database connection and table name
  private $conn;
  private $table_name = "paymentinvoice";
  
  // object properties
  public $Id;
  public $OrderId;
  public $AmountCharged;
  public $PaymentCardNumber;
  public $GeneratedAt;

  // Constructor with $db as database connection
  public function __construct($db) {
    $this->conn = $db;
  }

  public function findByOrderId($orderId) {
    // Select all query
    $query = "SELECT *, SUBSTRING(Id, 1, 8) as ShortId FROM {$this->table_name} WHERE OrderId = ? ORDER BY GeneratedAt DESC";
    // Prepare query statement
    $stmt = $this->conn->prepare($query);
    
    // sanitize
    $this->OrderId=htmlspecialchars(strip_tags($orderId));
  
    // bind id of record to delete
    $stmt->bindParam(1, $this->OrderId);

    // execute query
    $stmt->execute();
    return $stmt;
  }

  public function create() {
    // query to insert record
    $query = "INSERT INTO {$this->table_name} SET
                Id=:Id, OrderId=:OrderId, AmountCharged=:AmountCharged, PaymentCardNumber=:PaymentCardNumber, GeneratedAt=:GeneratedAt
              ";

    // prepare query
    $stmt = $this->conn->prepare($query);
  
    // sanitize
    $this->Id=htmlspecialchars(strip_tags($this->Id));
    $this->OrderId=htmlspecialchars(strip_tags($this->OrderId));
    $this->AmountCharged=htmlspecialchars(strip_tags($this->AmountCharged));
    $this->PaymentCardNumber=htmlspecialchars(strip_tags($this->PaymentCardNumber));
    $this->GeneratedAt = (new DateTime('now', new DateTimeZone('Asia/Karachi')))->format('Y-m-d H:i:s');
  
    // bind values
    $stmt->bindParam(":Id", $this->Id);
    $stmt->bindParam(":OrderId", $this->OrderId);
    $stmt->bindParam(":AmountCharged", $this->AmountCharged);
    $stmt->bindParam(":PaymentCardNumber", $this->PaymentCardNumber);
    $stmt->bindParam(":GeneratedAt", $this->GeneratedAt);
  
    // execute query
    return $stmt->execute() ? true : false;     
  }
}
?>