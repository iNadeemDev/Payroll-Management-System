<?php
    include 'connection.php';
    $emp_id = $_POST['emp_id'];

    $result = mysqli_query($con, "SELECT COUNT(*) AS `count` FROM `employees` WHERE `emp_id` = $emp_id");
    $row = mysqli_fetch_array($result);
    $count = $row['count'];
    
    if($count < 1){
        echo "Employee ID not found. Please try again.";
        header("location: ../admin/delt_emp.php?status=2");
    }
    else {
        $stmt = $con->prepare("DELETE FROM employees WHERE emp_id = $emp_id");
        $stmt->execute();
        if(isset($_POST['emp_id'])){
        echo "Employee Deleted Successfully.";
        header("location: ../admin/delt_emp.php?status=1");
        }
    }    
?>