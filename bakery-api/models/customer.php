<?php
class Customer {
  // Database connection and table name
  private $conn;
  private $table_name = "customer";
  
  // object properties
  public $Id;
  public $DisplayName;
  public $Email;
  public $Password;

  // Constructor with $db as database connection
  public function __construct($db) {
    $this->conn = $db;
  }

  public function findByEmail($email) {
    $query = "SELECT * FROM {$this->table_name} WHERE Email = ?";
    // Prepare query statement
    $stmt = $this->conn->prepare($query);

    // sanitize
    $this->Email=htmlspecialchars(strip_tags($email));
  
    // bind values
    $stmt->bindParam("1", $this->Email);
    $stmt->execute();
    return $stmt;
  }

  public function findById($id) {
    $query = "SELECT * FROM {$this->table_name} WHERE Id = ?";
    // Prepare query statement
    $stmt = $this->conn->prepare($query);

    // sanitize
    $this->Id=htmlspecialchars(strip_tags($id));
  
    // bind values
    $stmt->bindParam("1", $this->Id);
    $stmt->execute();
    return $stmt;
  }

  public function create() {
    // query to insert record
    $query = "INSERT INTO {$this->table_name} SET
                Id=:Id, DisplayName=:DisplayName, Email=:Email, Password=:Password
              ";

    // prepare query
    $stmt = $this->conn->prepare($query);
  
    // sanitize
    $this->Id=htmlspecialchars(strip_tags($this->Id));
    $this->DisplayName=htmlspecialchars(strip_tags($this->DisplayName));
    $this->Email=htmlspecialchars(strip_tags($this->Email));
    $this->Password=password_hash(htmlspecialchars(strip_tags($this->Password)), PASSWORD_BCRYPT);
  
    // bind values
    $stmt->bindParam(":Id", $this->Id);
    $stmt->bindParam(":DisplayName", $this->DisplayName);
    $stmt->bindParam(":Email", $this->Email);
    $stmt->bindParam(":Password", $this->Password);
  
    // execute query
    return $stmt->execute() ? true : false;
  }

  public function delete($id) {
    // delete query
    $query = "DELETE FROM {$this->table_name} WHERE Id = ?";
  
    // prepare query
    $stmt = $this->conn->prepare($query);
  
    // sanitize
    $this->$id=htmlspecialchars(strip_tags($id));
  
    // bind id of record to delete
    $stmt->bindParam(1, $this->Id);
  
    // execute query
    if($stmt->execute()){
        return true;
    }
  
    return false;
  }
  public function update() {
    // query to insert record
    $passwordQuery = !empty($this->Password) ? ', Password=:Password' : '';
    $query = "UPDATE {$this->table_name} SET DisplayName=:DisplayName $passwordQuery WHERE Id=:Id";

    // prepare query
    $stmt = $this->conn->prepare($query);
  
    // sanitize
    $this->Id=htmlspecialchars(strip_tags($this->Id));
    $this->DisplayName=htmlspecialchars(strip_tags($this->DisplayName));
    $stmt->bindParam(":Id", $this->Id);
    $stmt->bindParam(":DisplayName", $this->DisplayName);

    if (!empty($this->Password)) {
      $this->Password=password_hash(htmlspecialchars(strip_tags($this->Password)), PASSWORD_BCRYPT);
      $stmt->bindParam(":Password", $this->Password);
    }
  
    // execute query
    return $stmt->execute() ? true : false;     
  }
}
?>