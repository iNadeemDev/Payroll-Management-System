<?php
    include 'connection.php';
    session_start();
    $dept_id = $_SESSION['dept_id'];
    $user_id = $_SESSION['id'];
    //copying form data into variables
    $username = $_POST ['username'];
    $password = $_POST ['password'];
    $type = $_POST ['type'];    
    $emp_id = $_POST ['emp_id'];
    $nick = $_POST ['nickname'];

    $result = mysqli_query($con, "SELECT COUNT(*) AS `count` FROM `employees` WHERE `emp_id` = $emp_id");
    $row = mysqli_fetch_array($result);
    $count_emp = $row['count'];

    $result2 = mysqli_query($con, "SELECT COUNT(*) AS `count` FROM `users` WHERE `emp_id` = $emp_id");
    $row = mysqli_fetch_array($result2);
    $count_user = $row['count'];

    $result3 = mysqli_query($con, "SELECT COUNT(*) AS `count` FROM `users` WHERE `username` = '$username' ");
    $row = mysqli_fetch_array($result3);
    $count_username = $row['count'];

    $result4 = mysqli_query($con, "SELECT count(*) AS count FROM (((departments
    INNER JOIN positions ON positions.dept_id = departments.dept_id)
    INNER JOIN employees ON employees.pos_id = positions.pos_id)
    INNER JOIN users ON users.emp_id = employees.emp_id)
    WHERE departments.dept_id = $dept_id AND users.user_id = $user_id");
    $row4 = mysqli_fetch_array($result4);
    $count_in_dep = $row4['count'];

    if($count_emp < 1){
      echo "Employee ID does not exist. Please try again.";
      header("location: ../manager/add_user.php?status=2");
    }
    else if($count_user > 0){
      echo "User already exists.";
      header("location: ../manager/add_user.php?status=3");
    }
    else if($count_username > 0){
      echo "Username already exists. Try with unique username.";
      header("location: ../manager/add_user.php?status=4");
    }
    else if($count_in_dep == 0){
      echo "Soryy, This employee does not belong to your department.";
      header("location: ../manager/add_user.php?status=5");
    }
    else{
      // getting dept_id to be stored in users table as fk
      $dept = mysqli_query($con, "SELECT * FROM employees
      INNER JOIN positions ON positions.pos_id = employees.pos_id
      INNER JOIN departments ON departments.dept_id = positions.dept_id
      where employees.emp_id=$emp_id");

      $row = mysqli_fetch_array($dept);
      $dept_id = $row['dept_id'];

      $stmt = $con->prepare("INSERT INTO `users` (`username`, `password`, `type`, `emp_id`, `nickname`,dept_id) values (?,?,?,?,?,?)");
			$stmt->bind_param("sssisi", $username, $password, $type, $emp_id, $nick,$dept_id);
			$stmt->execute();
			echo "New user is added successfully!";
      header("location: ../admin/addUser.php?status=1");
			$stmt->close();
			$con->close();
		}
?>