<?php
$time_now=mktime(date('h')+5,date('i')+30,date('s'));
$to_date= date('d-m-Y');
$to_time= date('H:i:s',$time_now);

echo "date : ".$to_date."<br/>";
echo "time : ".$to_time."<br/>";

?>