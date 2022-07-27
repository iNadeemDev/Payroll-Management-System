<?php
    include 'connection.php';
    $user_id = $_POST['user_id'];
    session_start();
    $dept_id = $_SESSION['dept_id'];

    $result = mysqli_query($con, "SELECT count(*) AS `count` FROM `users` WHERE `user_id` = $user_id");
    $row = mysqli_fetch_array($result);
    $count_in_user = $row['count'];
    
    $result2 = mysqli_query($con, "SELECT count(*) AS count FROM (((departments
    INNER JOIN positions ON positions.dept_id = departments.dept_id)
    INNER JOIN employees ON employees.pos_id = positions.pos_id)
    INNER JOIN users ON users.emp_id = employees.emp_id)
    WHERE departments.dept_id = $dept_id AND users.user_id = $user_id");
    $row2 = mysqli_fetch_array($result2);
    $count_in_dep = $row2['count'];

    if($count_in_user == 0){
        echo "User ID not found. Please try again.";
        header("location: ../manager/delt_user.php?status=2");
    }
    else if($count_in_dep == 0){
        echo "Sorry! This user does not belong to your department.";
        header("location: ../manager/delt_user.php?status=3");
    }
    else {
        $stmt = $con->prepare("DELETE FROM users WHERE user_id = $user_id");
        $stmt->execute();
        echo "User Deleted Successfully.";
        header("location: ../manager/delt_user.php?status=1");
    }    
?>