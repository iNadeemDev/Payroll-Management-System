<?php
    include 'connection.php';
    $user_id = $_POST['user_id'];

    $result = mysqli_query($con, "SELECT COUNT(*) AS `count` FROM `users` WHERE `user_id` = $user_id");
    $row = mysqli_fetch_array($result);
    $count = $row['count'];
    
    if($count == 0){
        echo "User ID not found. Please try again.";
        header("location: ../admin/delt_user.php?status=2");
    }
    else {
        $stmt = $con->prepare("DELETE FROM users WHERE user_id = $user_id");
        $stmt->execute();
        echo "User Deleted Successfully.";
        header("location: ../admin/delt_user.php?status=1");
    }    
?>