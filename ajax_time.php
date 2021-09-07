<?php
include_once('./_common.php');

$ch = curl_init($user_remaining_secs_addr."?cp=".$cp."&svc=".$svc."&tel=".str_replace("-","",$member['mb_hp'])."&pwd=".substr($member['mb_hp'],-4)."");
curl_setopt($ch, CURLOPT_HEADER, false);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 1);
curl_setopt($ch, CURLOPT_TIMEOUT, 1);
$ret = curl_exec($ch);
curl_close($ch);
$hours = floor($ret / 3600);
$minutes = floor(($ret / 60) % 60);
$seconds = $ret % 60;

echo "회원님의 잔여시간 <span> ".$hours."시간 ".$minutes."분 ".$seconds."초 </span>";
?>