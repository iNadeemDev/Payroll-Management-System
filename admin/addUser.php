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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css">
    <script src="../jquery-3.2.1.min.js"></script>
    <title>Add New User</title>

    <script>  
        var check = function() {
            if (document.getElementById('password').value ==
                document.getElementById('confirm_password').value) {
                document.getElementById('message').style.color = 'green';
                document.getElementById('message').innerHTML = 'Password is matched!';
            } else {
                document.getElementById('message').style.color = 'red';
                document.getElementById('message').innerHTML = 'Password is not matching!';
            }
        }
    </script>


    <!--  User availability check -->
    <script>
    function checkAvailability() {
        $("#loaderIcon").show();
        jQuery.ajax({
        url: "check_availability.php",
        data:'username='+$("#username").val(),
        type: "POST",
        success:function(data){
            $("#user-availability-status").html(data);
        },
        error:function (){}
        });
    }
    </script>
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
                <p style="margin-left: 5%;">Please, enter the following details for the new user.</p>
                <hr style="border-width:1px;width:90%;text-align:center">
                <form class="addEmpForm" action="addUserProcess.php" method="post" enctype="multipart/form-data">
                    <label for="username">Username</label>
                    <input type="text" name="username" id="username" onBlur="checkAvailability()" required>
                    <span id="user-availability-status"></span>

                    <label for="password">Password</label>
                    <input name="password" id="password" type="password" onkeyup='check();' required/>
                    <i id="icon" class="fa fa-eye-slash" style="margin-left: 92%; transform: translateY(-18px); cursor: pointer;"></i>

                    <label for="password">Confirm Password</label>
                    <input type="password" name="confirm_pass" id="confirm_password"  onkeyup='check();' required/>
                    <span id="message"></span>

                    <label for="type">User Type</label>
                    <select id="type" name="type" required>
                        <option value="employee">Employee</option>
                        <option value="manager">Manager</option>
                    </select>

                    <label for="emp_id">Employee ID</label>
                    <input type="text" name="emp_id">

                    <label for="nickname">What was your childhood nickname?</label>
                    <input type="text" name="nickname">

                    <input style="margin-top: 15px;" type="submit" value="Add User"  style="color: white">
                </form>
                </table>
            </div>
        </div>
    </div>
    <div id="popup">
        New user has been created succeesfully!
    </div>
    
    <div id="popup2">
        Employee ID does not exist. Please try again.
    </div>
    
    <div id="popup3">
        User already exists.
    </div>
    
    <div id="popup4">
        Username already exists. Please, try with a unique username.
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
         window.setTimeout("hideMsg()", 2500);
       </script>';
    }
    ?>

<?php
    $Id_exist = false;

    if(isset($_GET['status']) && $_GET['status'] == 2){
       $Id_exist = true;
    }

    if($Id_exist)
    {
     echo '
       <script type="text/javascript">
         function hideMsg()
         {
            document.getElementById("popup2").style.visibility = "hidden";
         }

         document.getElementById("popup2").style.visibility = "visible";
         window.setTimeout("hideMsg()", 2500);
       </script>';
    }
    ?>

<?php
    $user_exist = false;

    if(isset($_GET['status']) && $_GET['status'] == 3){
       $user_exist = true;
    }

    if($user_exist)
    {
     echo '
       <script type="text/javascript">
         function hideMsg()
         {
            document.getElementById("popup3").style.visibility = "hidden";
         }

         document.getElementById("popup3").style.visibility = "visible";
         window.setTimeout("hideMsg()", 2500);
       </script>';
    }
    ?>

<?php
    $uname_exist = false;

    if(isset($_GET['status']) && $_GET['status'] == 4){
       $uname_exist = true;
    }

    if($uname_exist)
    {
     echo '
       <script type="text/javascript">
         function hideMsg()
         {
            document.getElementById("popup4").style.visibility = "hidden";
         }

         document.getElementById("popup4").style.visibility = "visible";
         window.setTimeout("hideMsg()", 2500);
       </script>';
    }
    ?>
</body>
</html>