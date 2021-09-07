<?php
include_once('./_common.php');

$od_hp = str_replace("-","",$member['mb_hp']);

$sql = "select count(*)as cnt from ".$g5['g5_shop_order_table']." where is_free=1 and od_hp = '{$od_hp}'";
$re = sql_fetch($sql);
if($re['cnt']>0){
	echo "dup";
	exit;
}

$sql = "select count(*)as cnt from ".$g5['g5_shop_order_table']." where is_free=1 and od_time BETWEEN '".date("Y-m-d")." 00:00:00' AND '".date("Y-m-d")." 23:59:59' ";
$re = sql_fetch($sql);
if($re['cnt'] >= $config['cf_2']){
	echo "over";
	exit;
}

?>