<?php
    include 'connection.php';
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

    if($count_emp < 1){
      echo "Employee ID does not exist. Please try again.";
      header("location: ../admin/addUser.php?status=2");
    }
    else if($count_user > 0){
      echo "User already exists.";
      header("location: ../admin/addUser.php?status=3");
    }
    else if($count_username > 0){
      echo "Username already exists. Try with unique username.";
      header("location: ../admin/addUser.php?status=4");
    }
    else{
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