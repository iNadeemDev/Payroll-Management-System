<?php
include 'connection.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>User Login</title>
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
                <p>LOGIN</p>            
                <div id="clock"></div>
                <form class="login_form" action="authenticate.php" method="post">
                    <label for="username">Username</label>
                    <input type="text" placeholder="Type Your Username" name="username">

                    <label for="username">Password</label>
                    <input type="password" placeholder="Type Your Password" name="password">

                    <input class="login-submit" type="submit" value="Login">                
                    <a href="forget_password.php" target="_self">Forgot Password</a>           
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
        Incorrect username or password!
    </div>

    <div id="popupLogin2">
        Congratulations! password changed successfully!
    </div>

    <?php
    $invalid = false;

    if(isset($_GET['status']) && $_GET['status'] == 1){
       $invalid = true;
    }

    if($invalid)
    {
     echo '
       <script type="text/javascript">
         function hideMsg()
         {
            document.getElementById("popupLogin").style.visibility = "hidden";
         }

         document.getElementById("popupLogin").style.visibility = "visible";
         window.setTimeout("hideMsg()", 3500);
       </script>';
    }
    ?> 

<?php
    $done = false;

    if(isset($_GET['status']) && $_GET['status'] == 2){
       $done = true;
    }

    if($done)
    {
     echo '
       <script type="text/javascript">
         function hideMsg()
         {
            document.getElementById("popupLogin2").style.visibility = "hidden";
         }

         document.getElementById("popupLogin2").style.visibility = "visible";
         window.setTimeout("hideMsg()", 3500);
       </script>';
    }
    ?>

</body>
</html>