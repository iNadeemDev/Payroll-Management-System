<?php
    include 'connection.php';
    //copying form data into variables
    $name = $_POST ['name'];
    $gender = $_POST ['gender'];
    $position = $_POST ['position'];
    $doj = $_POST ['doj'];
    $dob = $_POST ['dob'];
    $email = $_POST ['email'];
    $phone = $_POST ['phone'];
    $city = $_POST ['city'];
    $address = $_POST ['address'];

    //inserting into employees table
    $result = mysqli_query($con,"SELECT pos_id FROM positions WHERE pos_name = '$position'");
    $row = mysqli_fetch_array($result);
    $pos_id = $row[0];
    $stmt = $con->prepare("INSERT INTO `employees` (`name`, `gender`, `doj`, `dob`, `email`, `phone`, `city`, `address`, `pos_id`) values (?,?,?,?,?,?,?,?,?)");
		$stmt->bind_param("sssssissi", $name, $gender, $doj, $dob, $email, $phone, $city, $address, $pos_id);
		$stmt->execute();

    $result = mysqli_query($con,"SELECT max(emp_id) FROM employees");
    $row = mysqli_fetch_array($result);
    $lastId = $row[0];
    $val = 0;

    $alw = $con->prepare("INSERT INTO allowances (allowance , emp_id) VALUES (?,?)");
    $alw->bind_param("ii",$val,$lastId);
    $alw->execute();

    $ded = $con->prepare("INSERT INTO deductions (deduction , emp_id) VALUES (?,?)");
    $ded->bind_param("ii",$val,$lastId);
    $ded->execute();

		echo "Employee is added successfully!";
    echo "Employee ID :: ".$lastId;
    header("location: ../manager/addEmp.php?status=1");
?>