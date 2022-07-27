<?php
require_once("DBController.php");
$username = $_POST["username"];
$db_handle = new DBController();

if(!empty($_POST["username"])) {
  $query = "SELECT * FROM users WHERE username = '" . $username . "'";
  $user_count = $db_handle->numRows($query);
  if($user_count>0) {
      echo "<span class='status-not-available'> Username Not Available.</span>";
  }else{
      echo "<span class='status-available'> Username Available.</span>";
  }
}
?>