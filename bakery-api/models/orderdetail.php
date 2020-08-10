<?php
class OrderDetail {
  // Database connection and table name
  private $conn;
  private $table_name = "orderdetail";
  
  // object properties
  public $Id;
  public $OrderId;
  public $ProductId;
  public $UnitPrice;
  public $Quantity;

  // Constructor with $db as database connection
  public function __construct($db) {
    $this->conn = $db;
  }

  public function read() {
    // Select all query
    $query = "SELECT * FROM {$this->table_name} WHERE OrderId = ?";
    // Prepare query statement
    $stmt = $this->conn->prepare($query);
    
    // sanitize
    $this->OrderId=htmlspecialchars(strip_tags($this->OrderId));
  
    // bind id of record to delete
    $stmt->bindParam(1, $this->OrderId);

    // execute query
    $stmt->execute();
    return $stmt;
  }

  public function create() {
    // query to insert record
    $query = "INSERT INTO {$this->table_name} SET Id=:Id, OrderId=:OrderId, ProductId=:ProductId, UnitPrice=:UnitPrice, Quantity=:Quantity";

    // prepare query
    $stmt = $this->conn->prepare($query);
  
    // sanitize
    $this->Id=htmlspecialchars(strip_tags($this->Id));
    $this->OrderId=htmlspecialchars(strip_tags($this->OrderId));
    $this->ProductId=htmlspecialchars(strip_tags($this->ProductId));
    $this->UnitPrice=htmlspecialchars(strip_tags($this->UnitPrice));
    $this->Quantity=htmlspecialchars(strip_tags($this->Quantity));
  
    // bind values
    $stmt->bindParam(":Id", $this->Id);
    $stmt->bindParam(":OrderId", $this->OrderId);
    $stmt->bindParam(":ProductId", $this->ProductId);
    $stmt->bindParam(":UnitPrice", $this->UnitPrice);
    $stmt->bindParam(":Quantity", $this->Quantity);
  
    // execute query
    return $stmt->execute() ? true : false;     
  }

  public function findAllByOrderId($orderId) {
    // Select all query
    $query = "SELECT od.OrderId, od.ProductId, od.Quantity, od.UnitPrice, (od.Quantity * od.UnitPrice) as TotalCost
              FROM {$this->table_name} as od
              JOIN product as pro ON pro.Id = od.ProductId
              WHERE OrderId = ?
            ";
    // Prepare query statement
    $stmt = $this->conn->prepare($query);

    //sanitize
    $this->Id=htmlspecialchars(strip_tags($orderId));

    // bind values
    $stmt->bindParam("1", $this->Id);

    // execute query
    $stmt->execute();
    return $stmt;
  }
}
?>