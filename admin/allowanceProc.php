<?php
include 'connection.php';

$alw = $_POST['allowance'];
$emp_id = $_POST['emp_id'];

$result = mysqli_query($con, "SELECT COUNT(*) AS `count` FROM `employees` WHERE `emp_id` = $emp_id");
$row = mysqli_fetch_array($result);
$count = $row['count'];

$result = mysqli_query($con, "SELECT COUNT(*) AS `count` FROM `allowances` WHERE `emp_id` = $emp_id");
$row = mysqli_fetch_array($result);
$count_alw = $row['count'];
  
if($count < 1){
    echo "Employee ID does not exist. Please try again.";
    header("location: ../admin/allowance.php?status=2");
}
else {
    if($count_alw == 1){    //if allowance already exists then update it
        $stmt = mysqli_query($con,"UPDATE allowances SET allowance = $alw, alw_id = alw_id , emp_id = $emp_id WHERE emp_id = $emp_id");
        echo "Allowance is updated for the employee as it existed before...!";
        header("location: ../admin/allowance.php?status=1");
    }
    else{
        $stmt = $con->prepare("INSERT INTO allowances (allowance, emp_id) VALUES (?,?)");
        $stmt->bind_param("ii", $alw, $emp_id);
        $stmt->execute();
        echo "Allowance Added Successfully!";        
        header("location: ../admin/allowance.php?status=1");
    }
}
?>