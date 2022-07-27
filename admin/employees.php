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
    <title>Employees</title>
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
                <div class="area1_emp_adm">

                    <a href="addEmp.php"><p>Add New Employee</p></a>
                    <a href="delt_emp.php"><p>Delete An Employee</p></a>

                    
                    <a href="allowance.php"><p>Allowance</p></a>
                    <a href="deduction.php"><p>Deduction</p></a>

                    <div style="clear: both;"></div>
                </div>            
                <input class="searchbar_emp_adm" type="text" placeholder="Search Employee...">
                <hr style="border-width:1px;width:90%;text-align:center">
                <table>
                    <tr>
                        <th>Sr. No</th>
                        <th>Emp. ID</th>
                        <th>Name</th>
                        <th>Gender</th>
                        <th>Department</th>
                        <th>Position</th>
                        <th>Salary</th>
                        <th>Allowance</th>
                        <th>Deduction</th>
                        <th>DOJ</th>
                        <th>DOB</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>City</th>
                        <th>Address</th>
                    </tr>

                    <?php
                        $result = mysqli_query($con,"SELECT * FROM (((((departments
                        INNER JOIN positions ON positions.dept_id = departments.dept_id)
                        INNER JOIN employees ON employees.pos_id = positions.pos_id)
                        INNER JOIN allowances ON allowances.emp_id = employees.emp_id)
                        INNER JOIN deductions ON deductions.emp_id = employees.emp_id)
                        INNER JOIN salaries ON salaries.pos_id = positions.pos_id)
                        ORDER BY employees.emp_id
                        ");
                        $j = mysqli_num_rows($result);  # $j = No of rows in db
                        if ($j = 0){
                            echo "No result found!";
                        }
                        else {
                            $i = 0;
                            while($row = mysqli_fetch_array($result)) {
                        ?>
                                <tr>

                                <td><?php echo $i+1 ?></td>   <!-- Serial No Generate -->                                
                                <td><?php echo $row["emp_id"]; ?></td>
                                <td><?php echo $row["name"]; ?></td>
                                <td><?php echo $row["gender"]; ?></td>
                                <td><?php echo $row["dept_name"]; ?></td>
                                <td><?php echo $row["pos_name"]; ?></td>
                                <td><?php echo $row["amount"]; ?></td>
                                <td><?php echo $row["allowance"]; ?></td>
                                <td><?php echo $row["deduction"]; ?></td>
                                <td><?php echo $row["doj"]; ?></td>
                                <td><?php echo $row["dob"]; ?></td>
                                <td><?php echo $row["email"]; ?></td>
                                <td><?php echo $row["phone"]; ?></td>
                                <td><?php echo $row["city"]; ?></td>
                                <td><?php echo $row["address"]; ?></td>

                                </tr>
                            <?php
                                $i++;
                            }
                            ?>
                        <?php
                        }
                    ?>
                </table>
            </div>
        </div>
    </div>
</body>
</html>