
<?php
    $DATABASE_HOST = 'localhost';
    $DATABASE_USER = 'root';
    $DATABASE_PASS = '';
    $DATABASE_NAME = 'payroll';
    //connect using the info above.
    $con = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);
    if(!$con){
    die('Could not Connect My Sql:' .mysql_error());
    }
    date_default_timezone_set("Asia/Karachi");
?>