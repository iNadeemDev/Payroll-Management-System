<?php
require_once("DBController.php");
$username = $_POST["username"];
$password = $_POST["password"];
$db_handle = new DBController();

if(!empty($_POST["username"])) {
  $query = "SELECT * FROM users WHERE userName='" . $username . "' and password = '" . $password . ";
  $user_count = $db_handle->numRows($query);
  if($user_count>0) {
      header("location: admin/dashboard.html");
  }else{
      echo "<span class='status-available'> Username Available.</span>";
  }
}
?>