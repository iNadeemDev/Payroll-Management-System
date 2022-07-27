<?php
include 'connection.php';

$ded = $_POST['deduction'];
$emp_id = $_POST['emp_id'];

$result = mysqli_query($con, "SELECT COUNT(*) AS `count` FROM `employees` WHERE `emp_id` = $emp_id");
$row = mysqli_fetch_array($result);
$count = $row['count'];

$result = mysqli_query($con, "SELECT COUNT(*) AS `count` FROM `deductions` WHERE `emp_id` = $emp_id");
$row = mysqli_fetch_array($result);
$count_ded = $row['count'];
  
if($count < 1){
    echo "Employee ID does not exist. Please try again.";
    header("location: ../admin/deduction.php?status=2");
}
else {
    if($count_ded == 1){    //if deduction already exists then update it
        $stmt = mysqli_query($con,"UPDATE deductions SET deduction = $ded , ded_id = ded_id, emp_id = $emp_id WHERE emp_id = $emp_id");
        echo "Deduction is updated for the employee as it existed before...!";
        header("location: ../admin/deduction.php?status=1");
    }
    else{
        $stmt = $con->prepare("INSERT INTO deductions (deduction, emp_id) VALUES (?,?)");
        $stmt->bind_param("ii", $ded, $emp_id);
        $stmt->execute();
        echo "Deduction is entertained successfully!";
        header("location: ../admin/deduction.php?status=1");
    }
}
?>