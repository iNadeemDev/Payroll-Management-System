<?php
	include 'connection.php';
	// Initialize session
	session_start();
    $id = $_SESSION['id'];

	if ($_SESSION['loggedin'] !== TRUE) {
		header('location: ../login.php');
		exit;
	}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../styles.css">
    <title>Dashboard</title>
</head>
<body>
    <div style="overflow: hidden; height: 100vh;">
        <div class="header">
            <div class="logo">
                <img src="../images/pms_logo.jpeg" alt="pms_logo" width="85%">
            </div>
            <p>Payroll Management System</p>
            <a href="../home.html">Home</a>
            <a href="../support.php">Support</a>
            <a href="../announcement.php">Announcements</a>
            <a href="../faqs.html">FAQs</a>
        </div>
        <div class="sidebar">
            <div class="bg_sidebar">
                <div class="user">

                    <?php
                    $img = mysqli_query($con,"select picture from users where user_id = $id "); // fetch data from database
                    $row = mysqli_fetch_array($img);

                    if (
                        $row['picture'] == '' ||  $row['picture'] == null ||  empty($row['picture']) ||  !$row['picture'])
                        {
                        ?>
                        <img src="../images/user.png" alt="User Photo" width="45%"> <!-- This Dummy image will be displayed if user img not found in DB -->
                        <?php
                    }
                    else {
                        echo '<img src="data:image/jpeg;base64,'.base64_encode( $row['picture'] ).'" width="100" eight="100"/>';
                    }
                    ?>
                    <span style="display: block;">Welcome <?php echo $_SESSION['name'] ?></span>
                    
                </div>
                <hr style="border-width:1px;width:95%;text-align:center">
                <a href="../admin/dashboard.php">Dashboard</a>
                <a href="../admin/employees.php">Employees</a>
                <a href="../admin/departments.php">Departments</a>
                <a href="../admin/payrolls.php">Payrolls</a>
                <a href="../admin/users.php">Users</a>
                <a href="../logout.php">Logout</a>
            </div>
        </div>
        <div class="task_area">
            <div class="bg_task_area">
                <div class="area1_db_adm">
                    <h3>DASHBOARD</h3>
                    <a href="support.php">Support</a>
                    <a href="announcement.php">Announcements</a>
                    <?php
                        $today = date('Y-m-d');
                        $present = mysqli_query($con, "SELECT COUNT(*) AS `count` FROM `attendance` WHERE `attend_date` = '$today'");
                        $row = mysqli_fetch_array($present);
                        $countPresent = $row['count'];

                        $employees = mysqli_query($con, "SELECT COUNT(*) AS `count` FROM `employees`");
                        $row = mysqli_fetch_array($employees);
                        $totalEmp = $row['count'];

                        $absent = $totalEmp - $countPresent;

                        $percent = 100 * $countPresent / $totalEmp;
                    ?>
                    <a href="../admin/employees.php"><p style="padding: 15px 7px;">Total Employees<br><span><?php echo $totalEmp ?></span></p></a>
                    <a href="present.php"><p>Present<br><span><?php echo $countPresent ?></span></p></a>
                    <a href="absent.php"><p>Absent<br><span><?php echo $absent ?></span></p></a>
                    <p>Attendance<br><span><?php echo round($percent,2) ?></span> %</p>
                </div>
                <hr style="border-width:1px;width:90%;text-align:center">
                <div class="area2_db_adm">
                    <a href="../admin/employees.php">
                        <p>Employees</p>
                    </a>
                    <a href="../admin/departments.php">
                        <p>Departments</p>
                    </a>
                    <a href="../admin/payrolls.php">
                        <p>Payrolls</p>
                    </a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>