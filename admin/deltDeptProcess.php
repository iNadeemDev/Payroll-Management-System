<?php
    include 'connection.php';
    $dept_id = $_POST['dept_id'];


    $result = mysqli_query($con, "SELECT COUNT(*) AS `count` FROM `departments` WHERE `dept_id` = $dept_id");
    $row = mysqli_fetch_array($result);
    $count = $row['count'];
    
    if($count < 1){
        echo "Department ID not found. Please try again.";
        header("location: ../admin/delt_dept.php?status=2");
    }
    else {
        $stmt = $con->prepare("DELETE FROM departments WHERE dept_id = $dept_id");
        $stmt->execute();
        if(isset($_POST['dept_id'])){
        echo "Department Deleted Successfully.";
        header("location: ../admin/delt_dept.php?status=1");
        }
    }

    
?>