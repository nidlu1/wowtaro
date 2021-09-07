<?php
include_once('./_common.php');

if (!$is_member) die('0');

$sql = " UPDATE {$g5['member_table']} SET mb_cert=now() WHERE mb_no = '".$member['mb_no']."' ";
$result = sql_query($sql, false);

echo "OK";
exit;
?>