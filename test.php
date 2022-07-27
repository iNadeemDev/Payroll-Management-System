<?php
$myTime = strtotime("2021-07-22");  // Use whatever date format you want
$daysInMonth = cal_days_in_month(CAL_GREGORIAN, 7, 20); // 31
$workDays = 0;

while($daysInMonth > 0)
{
    $day = date("D", $myTime); // Sun - Sat
    if($day != "Sun" && $day != "Sat")
        $workDays++;

    $daysInMonth--;
    $myTime += 86400; // 86,400 seconds = 24 hrs.
}

echo "There are $workDays work days this month!";
?>