<?php
include 'connection.php';

$anc = $_POST['announcement'];
$dt = date('y-m-d');
$tm = date('h:i:s');
$stmt = $con->prepare("INSERT INTO announcements (announce_msg,dateposted,timeposted) VALUES (?,?,?)");
$stmt->bind_param("sss",$anc,$dt,$tm);
$stmt->execute();
echo "Announcement posted successfully!";
header("location: ../admin/announcement.php?status=1");
?>