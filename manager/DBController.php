<?php
class DBController {
    private $host = "localhost";
    private $user = "root";
    private $password = "";
    private $database = "payroll";
    
    private static $conn;
    
    function __construct() {
        DBController::$conn = $this->connectDB();
        if(!empty($this->conn)) {
            $this->selectDB();
        }
    }
    
    function connectDB() {
        $conn = mysqli_connect($this->host,$this->user,$this->password,$this->database);
        return $conn;
    }
    
    function selectDB() {
        mysqli_select_db($this->conn, $this->database);
    }
    
    function numRows($query) {
        $result  = mysqli_query(DBController::$conn, $query);
        $rowcount = mysqli_num_rows($result);
        return $rowcount;
    }
}
?>