<?php
    include 'connection.php';
    //copying form data into variables
    $name = $_POST ['name'];
    $email = $_POST ['email'];
    $subject = $_POST ['subject'];
    $description = $_POST ['description'];
    $dt = date('Y-m-d');
    $tm = date('H:i:s');

    //inserting into employees table
    $stmt = $con->prepare("INSERT INTO `support` (`spt_name`, `spt_email`, `spt_subject`, `spt_description`, `spt_date`, `spt_time`) values (?,?,?,?,?,?)");
	$stmt->bind_param("ssssss", $name, $email, $subject, $description, $dt, $tm);
	$stmt->execute();

	echo "Your form is submitted successfully! You will shortly be contacted at your provided email. Good Luck!";
    header("location: ../employee/message.php?status=2");
?>