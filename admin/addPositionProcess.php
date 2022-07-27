<?php
include 'connection.php';

$name = $_POST['pos_name'];
$dept_id = $_POST['dept_id'];

$result = mysqli_query($con, "SELECT COUNT(*) AS `count` FROM `departments` WHERE `dept_id` = $dept_id");
$row = mysqli_fetch_array($result);
$count = $row['count'];
  
if($count < 1){
    echo "Department ID does not exist. Please try again.";
}
else {
    $stmt = $con->prepare("INSERT INTO positions (pos_name, dept_id) VALUES (?,?)");
    $stmt->bind_param("ss", $name, $dept_id);
    $stmt->execute();
    echo "New Position Added Successfully!";
    header("location: ../admin/addPosition.php?status=1")
}

?>