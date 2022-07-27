<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>Support</title>
</head>
<body>
    <div>
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
        <div class="support_area">
            <div class="bg_support_img">
                <div class="support_container">                       
                    <p>SUPPORT</p>
                    <form class="support_form" action="supportProc.php" method="post">
                        <label for="name">Name</label>
                        <input type="text" name="name">
                        <label for="Email">Email</label>
                        <input type="Email" name="email" >
                        <label for="subject">Subject</label>
                        <input type="text" name="subject">
                        <label for="Message">Description</label>
                        <textarea id="subject" name="description" placeholder="Write something.." style="height:200px" 
                        style="width:100%" ></textarea>              
                        <input class="login-submit" type="submit" value="submit"> 
                    </form>
                </div>
            </div>
        </div>
    </div>
    

    <div id="mark">
        Your support form has been sent successfully!
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
            document.getElementById("mark").style.visibility = "hidden";
         }

         document.getElementById("mark").style.visibility = "visible";
         window.setTimeout("hideMsg()", 2500);
       </script>';
    }
    ?>
</body>    
</html>