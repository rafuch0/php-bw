<?php

header("content-type:text/html");

$devs = array('eth0');

if(isset($_GET['d']))
  $delay = strip_tags(intval($_GET['d']));
else $delay = 1;
$delay = $delay>0?$delay:1;

echo '<html><head><META HTTP-EQUIV="PRAGMA" CONTENT="NO-CACHE"><meta http-equiv="REFRESH" content="0"></head><body bgcolor=#000000><font color=#FFFFFF>';

for($i=0;$i<count($devs);$i++)
{
	$rx1[] = file_get_contents("/sys/class/net/".$devs[$i]."/statistics/rx_bytes");
	$tx1[] = file_get_contents("/sys/class/net/".$devs[$i]."/statistics/tx_bytes");
}

sleep($delay);

for($i=0;$i<count($devs);$i++)
{
	$rx2[] = file_get_contents("/sys/class/net/".$devs[$i]."/statistics/rx_bytes");
	$tx2[] = file_get_contents("/sys/class/net/".$devs[$i]."/statistics/tx_bytes");
}

for($i=0;$i<count($devs);$i++)
{
	$rx = (($rx2[$i] - $rx1[$i])/1024.0)/floatval($delay);
	$tx = (($tx2[$i] - $tx1[$i])/1024.0)/floatval($delay);

	echo  $devs[$i].'<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	      TX: <font color="#FF0000">'.$tx.'</font> kb/s<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	      RX: <font color="#00FF00">'.$rx.'</font> kb/s<br>
	      TotalSum: '.($tx2[$i]+$rx2[$i])/1024.0.' kb<br><br>';
}

echo '</body></html>';
?>
