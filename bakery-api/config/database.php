<?php
class Database{
    // Database credentials
    private $host = "127.0.0.1";
    private $port = 3308;
    private $db_name = "bakery";
    private $username = "bakery";
    private $password = "bakery";

    // Connection
    public $conn;

    // Get the database connection
    public function getConnection(){
      $this->conn = null;

      try {
        $this->conn = new PDO("mysql:host={$this->host};port={$this->port};dbname={$this->db_name};", $this->username, $this->password);
        $this->conn->exec("set names utf8");
      } catch(PDOException $exception){
        echo "Connection error: " . $exception->getMessage();
      }
      
      return $this->conn;
    }
}
?>