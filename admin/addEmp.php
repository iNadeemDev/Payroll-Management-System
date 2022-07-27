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
    <script src="../jquery-3.2.1.min.js"></script>
    <title>Add New Employee</title>
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
                <p style="margin-left: 5%;">Please, enter the following details for the new employee.</p>
                <hr style="border-width:1px;width:90%;text-align:center">
                <form class="addEmpForm" action="addEmpProcess.php" method="post">
                    <label for="name">Name</label>
                    <input type="text" name="name">

                    <label for="gender">Gender</label>
                    <select name="gender" id="">Gender
                        <option value="Male">Male</option>
                        <option value="Female">Female</option>
                    </select>


                    <label for="department">Department</label>

                    <?php
                    $DeptsNames = $con->query("select dept_name from departments");
                    ?>

                    <select id="type" name="department">
                        <?php
                        while ($row = $DeptsNames->fetch_assoc()) {
                            $name = $row['dept_name']; 
                            echo '<option value="'.$name.'">'.$name.'</option>';
                        }
                        ?>
                    </select>

                    <label for="position">Position</label>
                    <select id="size" name="position">
                    </select>

                    <!-- JAVASCRIPT FOR CHANGING OPTIONS -->
                    <script>
                        $(document).ready(function () {
                        $("#type").change(function () {
                            var val = $(this).val();
                            if (val == "Admin Department") {
                                $("#size").html("<option value='Finance'>Finance</option>   <option value='Assistant'>Assistant</option>    <option value='Human Resources'>Human Resources</option>    <option value=''>HOD</option>");
                            } else if (val == "Production Department") {
                                $("#size").html("<option value='Software Engineer'>Software Engineer</option>   <option value='Software Designer'>Software Designer</option>  <option value='Software Tester'>Software Tester</option>    <option value='Quality Assurance'>Quality Assurance</option>    <option value=''>HOD</option>");
                            } else if (val == "Sales Department") {
                                $("#size").html("<option value='Sales Person'>Sales Person</option>     <option value='Sales Associate'>Sales Associate</option>    <option value='Sales Specialist'>Sales Specialist</option>  <option value=''>HOD</option>");
                            } else if (val == "") {
                                $("#size").html("<option value=''>--select one--</option>");
                            }
                        });
                    });
                    </script>

                    <label for="doj">Date of Joining</label>
                    <input type="date" name="doj">

                    <label for="dob">Date of Birth</label>
                    <input type="date" name="dob">

                    <label for="email">Email</label>
                    <input type="email" name="email">

                    <label for="number">Phone</label>
                    <input type="tel" name="phone">

                    <label for="city">City</label>
                    <input type="text" name="city">

                    <label for="address">Address</label>
                    <textarea placeholder="Address..." name="address" id="" cols="10" rows="1"></textarea>
                    <input type="submit" value="Add Employee" style="color: white">
                </form>
                </table>
            </div>
        </div>
    </div>
    <div id="popup">
        New employee has been added succeesfully!
    </div>

    <?php
    $recordAdded = false;

    if(isset($_GET['status']) && $_GET['status'] == 1){
       $recordAdded = true;
    }

    if($recordAdded)
    {
     echo '
       <script type="text/javascript">
         function hideMsg()
         {
            document.getElementById("popup").style.visibility = "hidden";
         }

         document.getElementById("popup").style.visibility = "visible";
         window.setTimeout("hideMsg()", 3500);
       </script>';
    }
    ?>  
</body>
</html>