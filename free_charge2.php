<?php
include_once('./_common.php');

$od_id = date("YmdHis")."S".str_replace("-","",$member['mb_hp']);
$today=mktime(); 
$today_time = date('YmdHis', $today);

//parameter
$serviceId = "M1714254" ;   //테스트서버 : glx_api
$orderDate = $today_time ; //(YYYYMMDDHHMMSS)
$orderId = $od_id ;  
$userId = $member['mb_id'] ; 
$itemCode = "10분무료/였던것";
$amount = 0;
$sec = 300;
$od_dc_pwd = substr($member['mb_hp'],-4) ;


//if(strpos($hp,"-")!==false){
$hp = str_replace("-","",$member['mb_hp']);
//}

$sql = "select count(*)as cnt from ".$g5['g5_shop_order_table']." where is_free=1 and od_hp = '{$hp}'";
$re = sql_fetch($sql);
if($re['cnt']>0){
	alert("이벤트는 한번만 참여가 가능합니다.", G5_URL."/free_counsel_10min.php");
	exit;
}

$sql = "select count(*)as cnt from ".$g5['g5_shop_order_table']." where is_free=1 and od_time BETWEEN '".date("Y-m-d")." 00:00:00' AND '".date("Y-m-d")." 23:59:59' ";
$re = sql_fetch($sql);
if($re['cnt']>30){
	alert("오늘의 이벤트 신청이 모두 마감되었습니다\n내일 다시 신청해주세요\n감사합니다.", G5_URL."/free_counsel_10min.php");
	exit;
}

$sql = "insert into g5_shop_order set
		od_id='{$od_id}',
		mb_id='{$member['mb_id']}',
		od_name='{$member['mb_name']}',
		od_deposit_name='{$member['mb_name']}',
		od_b_name='{$member['mb_name']}',
		od_email='{$member['mb_email']}',
		od_hp='{$hp}',
		od_b_hp='{$hp}',
		od_pay_time='{$sec}',
		od_pwd='{$member['mb_password']}',
		od_ip='".$_SERVER['REMOTE_ADDR']."',
		od_time=now(),
		od_misu='{$amount}',
		od_status='입금',
		od_settle_case='{$itemCode}',
		is_free='1'
";

$re = sql_query($sql);
$ORDER_ID = $od_id;
if($re<=0){
?>
<script>
	alert("주문번호 중복입니다. 처음부터 결제해 주세요");
	opener.location.reload();
</script>
<?php
}

$time = time();
//include_once $_SERVER['DOCUMENT_ROOT']."/pay/update_free_charge_human.php";

$tel = trim(str_replace("-","",$member['mb_hp']));
$pwd = $od_dc_pwd;
$amt = trim($amount);


$params = "cp=$cp&svc=$svc&tel=$tel";
//$params = "cp=$cp&svc=$svc&tel=01055919609";
$url = $chk_telnum_addr."?".$params;

$ch = curl_init($url);
curl_setopt($ch, CURLOPT_HEADER, false);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$ret = curl_exec($ch);
curl_close($ch);

if($ret == "dup"){

	$params = "cp=$cp&svc=$svc&tel=$tel&pwd=$pwd&amt=$amt&sec=$sec";
	$url2 = $user_prepay_addr."?".$params;

	$ch2 = curl_init($url2);
	curl_setopt($ch2, CURLOPT_HEADER, false);
	curl_setopt($ch2, CURLOPT_RETURNTRANSFER, true);
	$ret2 = curl_exec($ch2);
	curl_close($ch2);

	$return['code']	= $ret2;

	//echo "url:".$url."<br>";
	//echo "ret2:".$ret2."<br>";
	if($ret2=="ok"){		
		$sql_use_list = "update g5_shop_order set dc_status='승인완료', test='{$url2}' where od_id='{$ORDER_ID}'";
		sql_query($sql_use_list);
	} else if($ret2=="dif"){
		$sql_use_list = "update g5_shop_order set dc_status='실패1', test='{$url2}' where od_id='{$ORDER_ID}'";
		sql_query($sql_use_list);
	}else{
		$sql_use_list = "update g5_shop_order set dc_status='실패1-1', test='{$url2}' where od_id='{$ORDER_ID}'";
		sql_query($sql_use_list);
	}


// 신규등록후 충전
}else{

	$params = "cp=$cp&svc=$svc&tel=$tel&pwd=$pwd&amt=$amt&sec=$sec";
	$url2 = $new_user_addr."?".$params;

	$ch2 = curl_init($url2);
	curl_setopt($ch2, CURLOPT_HEADER, false);
	curl_setopt($ch2, CURLOPT_RETURNTRANSFER, true);
	$ret2 = curl_exec($ch2);
	curl_close($ch2);

	$return['code']	= $ret2;
	//echo "url:".$url."<br>";
	//echo "ret2:".$ret2."<br>";
	if($ret2=="ok"){
		$return['msg'] =  "신규등록과 충전을 성공 하였습니다.";
		
		$sql_use_list = "update g5_shop_order set dc_status='신규승인', test='{$url2}' where od_id='{$ORDER_ID}'";
		sql_query($sql_use_list);
	}else if($ret2=="dup"){
		$sql_use_list = "update g5_shop_order set dc_status='실패2', test='{$url2}' where od_id='{$ORDER_ID}'";
		sql_query($sql_use_list);
	}else{
		$sql_use_list = "update g5_shop_order set dc_status='실패2-1', test='{$url2}' where od_id='{$ORDER_ID}'";
		sql_query($sql_use_list);
	}
}

alert("신청되었습니다.", "./free_counsel_10min.php");
exit;
?>