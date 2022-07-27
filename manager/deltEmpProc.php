<?php
    include 'connection.php';
    session_start();
    $emp_id = $_POST['emp_id'];
    $dept_id = $_SESSION['dept_id'];

    $result = mysqli_query($con, "SELECT count(*) AS count FROM employees WHERE emp_id = $emp_id");
    $row = mysqli_fetch_array($result);
    $count_in_emp = $row['count'];

    $result2 = mysqli_query($con, "SELECT count(*) AS count FROM employees 
    INNER JOIN positions ON positions.pos_id = employees.pos_id
    INNER JOIN salaries ON salaries.pos_id = positions.pos_id
    INNER JOIN departments ON departments.dept_id = positions.dept_id
    WHERE departments.dept_id = $dept_id AND employees.emp_id = $emp_id");
    $row2 = mysqli_fetch_array($result2);
    $count_in_dep = $row2['count'];
    
    if($count_in_emp < 1){
        echo "Employee ID not found";
        header("location: ../manager/delt_employee.php?status=2");
    }
    else if($count_in_dep < 1){
        echo "Sorry! This Employee does not belong to your department!";
        header("location: ../manager/delt_employee.php?status=3");
    }
    else {
        $stmt = $con->prepare("DELETE FROM employees WHERE emp_id = $emp_id");
        $stmt->execute();
        if(isset($_POST['emp_id'])){
        echo "Employee Deleted Successfully.";
        header("location: ../manager/delt_employee.php?status=1");
        }
    }    
?>