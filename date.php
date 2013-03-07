<?php
    $week_start =  date('Ymd', strtotime('Monday this week'));
    echo $week_start."\n";
    $month = date('Ymd', strtotime("Sunday +7 weeks"));
    echo $month;
# echo date('Ymd', strtotime('+8 weeks', mktime(0, 0, 0, )));
?>
