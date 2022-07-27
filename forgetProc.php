<?php
    include 'connection.php';
    $username = $_POST['username'];
    $nickname = $_POST['nickname'];
    $result = mysqli_query($con, "SELECT count(*) AS count FROM users WHERE username = '$username' AND nickname = '$nickname'");
    $row = mysqli_fetch_array($result);
    $count = $row['count'];

    if($count == 1){
        session_start();
        $_SESSION["forgetSession"] = TRUE;
        header("location: changepass.php");
    }
    else{
        echo "username and/or nickname not found. Please try again with correct credentials.";
        header("location: forget_password.php?status=1");
    }

?>