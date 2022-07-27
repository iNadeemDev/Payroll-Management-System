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
    <title>Announcements</title>
</head>
<body>
    <div class="bg_announce">
        <div class="header">
            <div class="logo">
                <img src="images/pms_logo.jpeg" alt="pms_logo" width="85%">
            </div>
            <p class="pa">Payroll Management System</p>
            <a href="home.html">Home</a>
            <a href="support.php">Support</a>
            <a href="announcement.php">Announcements</a>
            <a href="faqs.html">FAQs</a>
        </div>	

        <div>
            <h1>ANNOUNCEMENTS</h1>
        </div>
        <?php
        $result = mysqli_query($con,"SELECT * FROM announcements");
        while($row = mysqli_fetch_array($result)) {
        ?>
        <div class="read-more-container">
            
            <div class="announce_container" style="border: 1px solid green">
                <p >Date: <?php echo $row['dateposted']?> Time: <?php echo $row['timeposted']?>
                <span class="read-more-text">
                    <?php echo $row['announce_msg'] ?>
                </span>
                </p>
            <span class="read-more-btn">Read More...</span>
            </div>

           
    
        </div>
        <?php 
        }        
        ?>
    </div>
    <script>
        const parentContainer =  document.querySelector('.read-more-container');

        parentContainer.addEventListener('click', event=>{

        const current = event.target;

        const isReadMoreBtn = current.className.includes('read-more-btn');

        if(!isReadMoreBtn) return;

        const currentText = event.target.parentNode.querySelector('.read-more-text');

        currentText.classList.toggle('read-more-text--show');

        current.textContent = current.textContent.includes('Read More') ? 
        "Read Less..." : "Read More...";
        })
    </script>
</body>
</html>