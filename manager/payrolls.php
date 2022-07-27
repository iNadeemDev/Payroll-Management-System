<?php
	include 'connection.php';
	// Initialize session
	session_start();
    $id = $_SESSION['id'];
    $dept_id = $_SESSION['dept_id'];

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
                    <span style="display: block;">Welcome <?php echo ucfirst($_SESSION['name']) ?></span>
                    
                </div>
                <hr style="border-width:1px;width:95%;text-align:center">
                <a href="../manager/dashboard.php">Dashboard</a>
                <a href="../manager/employees.php">Employees</a>
                <a href="../manager/payrolls.php">Payrolls</a>
                <a href="../manager/positions.php">Positions</a>
                <a href="../manager/users.php">Users</a>
                <a href="../logout.php">Logout</a>
            </div>
        </div>
        <div class="task_area">
            <div class="bg_task_area">
                <input class="searchbar_prl_mng" type="text" placeholder="Search Payroll...">
                <hr style="border-width:1px;width:90%;text-align:center">
                <table>
                    <tr>
                        <th>Sr. No</th>
                        <th>Emp. ID</th>
                        <th>Emp. Name</th>
                        <th>Dept. Name</th>
                        <th>Positions</th>
                        <th>Presents</th>
                        <th>Absents</th>
                        <th>Basic Salary</th>
                        <th>Earned Salary</th>
                        <th>Allowance</th>
                        <th>Deduction</th>
                        <th>Net Salary</th>
                        <th>Status</th>
                    </tr>
                    <?php

                    /**** PHP for attendance counts, absent counts, deduction for leaves count etc   *********/
                    $today = date('Y-m-d');
                    $first = date('Y-m-00');
                    $attend = mysqli_query($con,"SELECT count(*) AS count FROM attendance WHERE attend_date > '$first'");
                    $row = mysqli_fetch_array($attend);
                    $attendCount = $row['count'];

                    //   PHP to count absents in working days
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
                    $daysInMonth = cal_days_in_month(CAL_GREGORIAN, date('m'), date('Y'));
                    $workDaysMonth = 0;
                    // PHP to count total working days in a month
                    while($daysInMonth > 0)
                    {
                        $day = date("D", $myTime); // Sun - Sat
                        if($day != "Sun")
                            $workDaysMonth++;

                        $daysInMonth--;
                        $myTime += 86400; // 86,400 seconds = 24 hrs.
                    }
                    $absentCount = $workDays - $attendCount;

                    $percent = 100 * $attendCount / $workDays;

                    $result = mysqli_query($con,"SELECT * FROM departments
                    INNER JOIN positions ON positions.dept_id = departments.dept_id
                    INNER JOIN employees ON employees.pos_id = positions.pos_id
                    INNER JOIN salaries ON salaries.pos_id = positions.pos_id
                    INNER JOIN allowances ON allowances.emp_id = employees.emp_id
                    INNER JOIN deductions ON deductions.emp_id = employees.emp_id
                    WHERE departments.dept_id = $dept_id
                    ORDER BY employees.emp_id");
                    $i=1;
                    while($row = mysqli_fetch_array($result)){
                    ?>
                    <tr>
                        <td>
                            <?php echo $i ?>
                        </td>

                        <td>
                            <?php
                            $emp_id = $row['emp_id'];
                            echo $emp_id?>

                        </td>

                        <td>
                            <?php echo $row['name']?>
                        </td>

                        <td>
                            <?php echo $row['dept_name']?>
                        </td>                        

                        <td>
                            <?php echo $row['pos_name']?>
                        </td>
                        
                        <td>
                            <?php
                            $attend = mysqli_query($con,"SELECT count(*) AS count FROM attendance WHERE attend_date > '$first' AND emp_id = $emp_id");
                            $rows = mysqli_fetch_array($attend);
                            $attendCount = $rows['count'];
                            echo $attendCount;
                            ?>
                        </td>

                        <td>
                            <?php
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
                            echo $absentCount;
                            ?>
                        </td>

                        <td>
                            <?php echo $row['amount']?>
                        </td>

                        <td>
                            <?php
                            $sal_per_day = $row['amount'] / $workDaysMonth;
                            $earned = $attendCount * $sal_per_day;
                            echo round($earned,2);
                            ?>
                        </td>
                        
                        <td>
                            <?php echo $row['allowance']?>
                        </td>

                        <td>
                            <?php
                                $ded = $sal_per_day * $absentCount;
                                echo round($ded,2);
                            ?>
                        </td>

                        <td>
                            <?php
                                $net_sal = $earned + $row['allowance'];
                                echo round($net_sal,2);
                            ?>
                        </td>
                        <td>
                            
                        </td>
                    </tr>
                    <?php 
                    $i++ ;
                    } 
                    ?>
                </table>
            </div>
        </div>
    </div>    
</body>
</html>