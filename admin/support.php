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
    <title>Payrolls</title>
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
                <p style="margin-left: 5%">All the SUPPORT FORMS appear here. (Latest applications appear on the top)</p>
                <hr style="border-width:1px;width:90%;text-align:center">
                <?php
                $result = mysqli_query($con,"SELECT * FROM support ORDER BY spt_id DESC");
                ?>
                <?php
                    while($row = mysqli_fetch_array($result)){
                ?>
                    
                <table style="margin-left: 5%; width: 90%">
                    <tr>
                        <td style="border: 2px solid brown;">
                            <?php
                            echo "Date : " .$row['spt_date']. " Time : " .$row['spt_time'];
                            echo "<p> NAME : ".$row['spt_name']."</p>";
                            echo "<p> EMAIL : ".$row['spt_email']."</p>";
                            echo "<p>SUBJECT: ".$row['spt_subject']."</p>";
                            echo "DESCRIPTION : ";
                            echo "<p>".$row['spt_description']."</p>";
                            ?>
                        </td>
                    </tr>
                </table>
                <br>
                <?php
                    }
                ?>
            </div>
        </div>
    </div>    
</body>
</html>