<?php
	include 'connection.php';
	// Initialize session
	session_start();
    $id = $_SESSION['id'];
    $username = $_SESSION['name'];
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
    <title>Positions</title>
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
                    <span style="display: block;">Welcome <?php echo ucfirst($username) ?></span>
                    
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
                <div class="area1_emp_mng">
                    <span style="margin-left: 5%">All the positions in this department are listed below:</span>
                </div>
                <hr style="border-width:1px;width:90%;text-align:center">
                <table style="width: 90%; margin-left: 5%;">
                    <tr>
                        <th>Sr. No</th>
                        <th>Position ID</th>
                        <th>Position Name</th>
                        <th>Basic Salary</th>
                        <th>Department ID</th>
                    </tr>
                    <?php
                        $result = mysqli_query($con,"SELECT * FROM positions 
                        INNER JOIN salaries ON salaries.pos_id = positions.pos_id
                        WHERE dept_id = $dept_id ORDER BY positions.pos_id");
                        $j = mysqli_num_rows($result);
                        if ($j = 0){
                            echo "No result found!";
                        }
                        else {
                            $i = 1;
                            while($row = mysqli_fetch_array($result)) {
                        ?>
                                <tr>

                                <td><?php echo $i ?></td>   <!-- Serial No Generate -->                                
                                <td><?php echo $row["pos_id"]; ?></td>
                                <td><?php echo $row["pos_name"]; ?></td>
                                <td><?php echo $row["amount"]; ?></td>
                                <td><?php echo $dept_id ?></td>

                                </tr>
                            <?php
                                $i++;
                            }
                        }
                    ?>
                </table>
            </div>
        </div>
    </div>
</body>
</html>