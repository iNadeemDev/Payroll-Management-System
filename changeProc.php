<?php
    include 'connection.php';
    $uname = $_POST['username'];
    $pwd = $_POST['newpass'];

    
    $result = mysqli_query($con, "SELECT count(*) AS count FROM users WHERE username = '$uname'");
    $row = mysqli_fetch_array($result);
    $count = $row['count'];
    if($count == 1){
        $stmt = mysqli_query($con,"UPDATE users SET password = '$pwd' where username = '$uname'");
        echo "Congratulations! Your password has been chnaged now.";
        header("location: login.php?status=2");
    }
    else{
        echo "Invalid username. Please try again with correct credentials.";
        header("location: changepass.php?status=1");
    }      
?>