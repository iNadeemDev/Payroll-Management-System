<?php
	include 'connection.php';
	// Initialize session
	session_start();
    $id = $_SESSION['id'];
    $emp_id = $_SESSION['emp_id'];

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
                    <span style="display: block;">Welcome <?php echo ucfirst($_SESSION['name']) ?></span>
                    
                </div>
                <hr style="border-width:1px;width:95%;text-align:center">
                <a href="../employee/dashboard.php">Dashboard</a>
                <a href="../employee/profile.php">Profile</a>
                <a href="../employee/payroll.php">Payroll</a>
                <a href="../employee/message.php">Messages</a>
                <a href="../logout.php">Logout</a>
            </div>
        </div>
        <div class="task_area">
            <div class="bg_task_area">
                <div class="area1_db_emp">
                    <h3>DASHBOARD</h3>

                    <?php
                        $today = date('Y-m-d');
                        $first = date('Y-m-00');
                        $attend = mysqli_query($con,"SELECT count(*) AS count FROM attendance WHERE attend_date > '$first' AND emp_id = $emp_id");
                        $row = mysqli_fetch_array($attend);
                        $attendCount = $row['count'];

                        /**********   PHP to count absents in working days  *************/
                        $myTime = strtotime(date('Y-m-d'));
                        $workDays = 0;
                        $days = date('d');
                        while($days > 0)
                        {
                            $day = date("D", $myTime); // Sun - Sat
                            if($day != "Sun")
                                $workDays++;

                            $days--;
                            $myTime += 86400; // 86,400 seconds = 24 hrs.
                        }
                        $absentCount = $workDays - $attendCount;

                        $percent = 100 * $attendCount / $workDays;
                    ?>

                    <p>Attendance<br><span><?php echo $attendCount ?></span></p>
                    <p>Absent<br><span><?php echo $absentCount ?></span></p>
                    <p>Leaves<br><span>00</span></p>
                    <p>Attendance %<br><span><?php echo round($percent,2) ?></span></p>
                </div>
                <hr style="border-width:1px;width:95%;text-align:center">
                <div class="area2_db_emp">
                    <a href="../employee/profile.php">
                        <p>Profile</p>
                    </a>
                    <a href="../employee/payroll.php">
                        <p>Payrolls</p>
                    </a>
                    <a href="../employee/message.php">
                        <p>Messages</p>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <div id="mark">
        Your attendance for today has been marked successfully!
    </div>

    <?php
    $marked = false;

    if(isset($_GET['status']) && $_GET['status'] == 3){
       $marked = true;
    }

    if($marked)
    {
     echo '
       <script type="text/javascript">
         function hideMsg()
         {
            document.getElementById("mark").style.visibility = "hidden";
         }

         document.getElementById("mark").style.visibility = "visible";
         window.setTimeout("hideMsg()", 3500);
       </script>';
    }
    ?>
</body>
</html>