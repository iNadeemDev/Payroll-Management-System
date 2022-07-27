<?php
    include 'connection.php';
    $pos_id = $_POST['pos_id'];

    $result = mysqli_query($con, "SELECT COUNT(*) AS `count` FROM `positions` WHERE `pos_id` = $pos_id");
    $row = mysqli_fetch_array($result);
    $count = $row['count'];
    
    if($count < 1){
        echo "Position ID not found. Please try again.";
        header("location: ../admin/delt_position.php?status=2");
    }
    else {
        $stmt = $con->prepare("DELETE FROM positions WHERE pos_id = $pos_id");
        $stmt->execute();
        if(isset($_POST['pos_id'])){
        echo "Position Deleted Successfully.";
        header("location: ../admin/delt_position.php?status=1");
        }
    }

    
?>