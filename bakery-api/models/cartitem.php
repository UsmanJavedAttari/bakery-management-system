<?php
class CartItem {
  // Database connection and table name
  private $conn;
  private $table_name = "cartitem";
  
  // object properties
  public $CartId;
  public $ProductId;
  public $Quantity;

  // Constructor with $db as database connection
  public function __construct($db) {
    $this->conn = $db;
  }

  public function findAllByCartId($cartId) {
    // Select all query
    $query = "SELECT c.CartId, c.ProductId, c.Quantity, (c.Quantity * pro.Price) as TotalCost
              FROM {$this->table_name} as c
              JOIN product as pro ON pro.Id = c.ProductId
              WHERE CartId = ?
            ";
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

  public function create() {
    // query to insert record
    $query = "INSERT INTO {$this->table_name} SET
                CartId=:CartId, ProductId=:ProductId, Quantity=:Quantity
              ";

    // prepare query
    $stmt = $this->conn->prepare($query);
  
    // sanitize
    $this->CartId=htmlspecialchars(strip_tags($this->CartId));
    $this->ProductId=htmlspecialchars(strip_tags($this->ProductId));
    $this->Quantity=htmlspecialchars(strip_tags($this->Quantity));
  
    // bind values
    $stmt->bindParam(":CartId", $this->CartId);
    $stmt->bindParam(":ProductId", $this->ProductId);
    $stmt->bindParam(":Quantity", $this->Quantity);
  
    // execute query
    return $stmt->execute() ? true : false;     
  }

  public function itemExists($productId, $cartId) {
    // Select all query
    $query = "SELECT * FROM {$this->table_name} WHERE CartId=:CartId AND ProductId=:ProductId";
    // Prepare query statement
    $stmt = $this->conn->prepare($query);

    //sanitize
    $this->ProductId=htmlspecialchars(strip_tags($productId));
    $this->CartId=htmlspecialchars(strip_tags($cartId));

    // bind values
    $stmt->bindParam(":CartId", $this->CartId);
    $stmt->bindParam(":ProductId", $this->ProductId);

    // execute query
    $stmt->execute();
    return $stmt;
  }

  public function updateQuantity() {
    // query to insert record
    $query = "UPDATE {$this->table_name} SET Quantity=:Quantity WHERE ProductId=:ProductId AND CartId=:CartId";

    // prepare query
    $stmt = $this->conn->prepare($query);
  
    // sanitize
    $this->Quantity=htmlspecialchars(strip_tags($this->Quantity));
    $this->Quantity = intval($this->Quantity) <= 1 ? 1 : $this->Quantity;
  
    // bind values
    $stmt->bindParam(":CartId", $this->CartId);
    $stmt->bindParam(":ProductId", $this->ProductId);
    $stmt->bindParam(":Quantity", $this->Quantity);
  
    // execute query
    return $stmt->execute() ? true : false;     
  }

  public function delete($cartId, $productId) {
    // delete query
    $query = "DELETE FROM {$this->table_name} WHERE CartId=:CartId AND ProductId=:ProductId";
  
    // prepare query
    $stmt = $this->conn->prepare($query);
  
    // sanitize
    $this->CartId=htmlspecialchars(strip_tags($cartId));
    $this->ProductId=htmlspecialchars(strip_tags($productId));
  
    // bind id of record to delete
    $stmt->bindParam(':CartId', $this->CartId);
    $stmt->bindParam(':ProductId', $this->ProductId);
  
    // execute query
    return $stmt->execute() ? true : false;
  }

  public function deleteAll($cartId) {
    // delete query
    $query = "DELETE FROM {$this->table_name} WHERE CartId=:CartId";
  
    // prepare query
    $stmt = $this->conn->prepare($query);
  
    // sanitize
    $this->CartId=htmlspecialchars(strip_tags($cartId));
  
    // bind id of record to delete
    $stmt->bindParam(':CartId', $this->CartId);
  
    // execute query
    return $stmt->execute() ? true : false;
  }

  public function calculateTotalAmount($cartId) {
    $query = "SELECT SUM(pro.Price * ci.Quantity) AS TotalAmount
              FROM cartitem AS ci
              JOIN product AS pro ON pro.Id = ci.ProductId
              WHERE ci.CartId=:CartId
            ";
            
    // prepare query
    $stmt = $this->conn->prepare($query);
  
    // sanitize
    $this->CartId=htmlspecialchars(strip_tags($cartId));
  
    // bind id of record to delete
    $stmt->bindParam(':CartId', $this->CartId);
  
    // execute query
    $stmt->execute();
    return $stmt;
  }
}
?>