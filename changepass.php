
<?php
	include 'connection.php';
	// Initialize session
	session_start();

	if ($_SESSION['forgetSession'] !== TRUE) {
		header('location: forget_password.php');
		exit;
	}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>Change Password</title>
</head>
<body>
    <div style="height: 100vh; overflow: hidden;">
        <div class="header">
            <div class="logo">
                <img src="images/pms_logo.jpeg" alt="pms_logo" width="85%">
            </div>
            <p>Payroll Management System</p>
            <a href="home.html">Home</a>
            <a href="support.php">Support</a>
            <a href="announcement.php">Announcements</a>
            <a href="faqs.html">FAQs</a>
        </div>
        
        <div class="bg_login_img">
            <div class="login_container">
                <p>Change Password</p>            
                <div id="clock"></div>
                <form class="login_form" action="changeProc.php" method="post">
                    <label for="username">Username</label>
                    <input type="text" placeholder="Type Your Username" name="username">

                    <label for="newpass">New Password</label>
                    <input type="text" placeholder="Type Your New Password" name="newpass">

                    <label for="confirm">Confirm New Password</label>
                    <input type="text" placeholder="Type New Password Again" name="">

                    <input class="login-submit" type="submit" value="Proceed">      
                </form>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        var clockElement = document.getElementById('clock');
        function clock() {
            clockElement.textContent = new Date().toLocaleTimeString();
        }
        setInterval(clock, 1000);
    </script>

    <div id="popupLogin">
        Invalid username. Try again.
    </div>

    <?php
    $changed = false;

    if(isset($_GET['status']) && $_GET['status'] == 1){
       $changed = true;
    }

    if($changed)
    {
     echo '
       <script type="text/javascript">
         function hideMsg()
         {
            document.getElementById("popupLogin").style.visibility = "hidden";
         }

         document.getElementById("popupLogin").style.visibility = "visible";
         window.setTimeout("hideMsg()", 3000);
       </script>';
    }
    ?> 
</body>
</html>