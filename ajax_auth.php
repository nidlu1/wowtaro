<?php
include_once('./_common.php');

if ( !$member['mb_id'] ) {
	echo "NO";
	exit;
}
else {
	if ( $_REQUEST['chk_val'] == 7 ) {
		$sql = "SELECT COUNT(od_id) AS cnt FROM ".$g5['g5_shop_order_table']." WHERE od_hp='".str_replace("-","",$member['mb_hp'])."' AND od_cart_price='1100' AND od_status='입금' ";
		$row = sql_fetch($sql);

		if ( $row['cnt'] >= 2 ) {
			echo "NO2";
			exit;
		}
		else {
			echo "OK";
			exit;
		}
	}
	else {
		echo "OK";
		exit;
	}
}
?>