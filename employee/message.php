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
                <a href="../employee/dashboard.php">Dashboard</a>
                <a href="../employee/profile.php">Profile</a>
                <a href="../employee/payroll.php">Payroll</a>
                <a href="../employee/message.php">Messages</a>
                <a href="../logout.php">Logout</a>
            </div>
        </div>
        <div class="task_area">
            <div class="bg_task_area">
                <p style="margin-left: 5%;">Please write in the below form and your message will be sent to the admin</p>
                <hr style="border-width:1px;width:90%;text-align:center">

                <form class="addEmpForm" action="supportProc.php" method="post">
                    <label for="name">Name</label>
                    <input type="text" name="name">

                    <label for="email">Email</label>
                    <input type="email" name="email">

                    <label for="">Subject</label>
                    <input type="text" name="subject">

                    <label for="description">Description</label>
                    <textarea name="description" id="" cols="50" rows="18"></textarea>
                    <input type="submit" value="Send Message"  style="color: white">
                </form>
            </div>
        </div>
    </div>

    <div id="popup2">
        Your message has been sent successfully!
    </div>
    <?php
    $sent = false;

    if(isset($_GET['status']) && $_GET['status'] == 2){
       $sent = true;
    }

    if($sent)
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
</body>
</html>