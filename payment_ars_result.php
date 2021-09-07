<?php
include_once('./_common.php');
/*
array(25) {["PayMethod"]=>string(4) "CARD"["MID"]=>string(10) "testpay01m"["TID"]=>string(30) "testpay01m01081812300825509905"["mallUserID"]=>string(20) "whatismyid@naver.com"["Amt"]=>string(5) "33000"["name"]=>string(20) "whatismyid@naver.com"["GoodsName"]=>string(17) "WOWtarot - DC PAY"["OID"]=>string(16) "2018123008252725"["MOID"]=>string(16) "2018123008252725"["AuthDate"]=>string(12) "181230082645"["AuthCode"]=>string(8) "54579423"["ResultCode"]=>string(4) "3001"["ResultMsg"]=>string(20) "카드 결제 성공"["VbankNum"]=>string(0) ""["MerchantReserved"]=>string(0) ""["MallReserved"]=>string(0) ""["SUB_ID"]=>string(0) ""["fn_cd"]=>string(2) "01"["fn_name"]=>string(6) "비씨"["CardQuota"]=>string(2) "00"["BuyerEmail"]=>string(20) "whatismyid@naver.com"["BuyerAuthNum"]=>string(0) ""["ErrorCode"]=>string(1) "O"["ErrorMsg"]=>string(27) "IBK비씨체크OK: 54579423"["FORWARD"]=>string(1) "Y" } 
http://fortune.urbannet.co.kr/payment_result.php?PayMethod=VBANK&MID=pgwow1entm&TID=pgwow1entm03011906181550277679&mallUserID=kjy@newbird.co.kr&BuyerName=%ED%85%8C%EC%8A%A4%ED%84%B0&BuyerEmail=kjy@newbird.co.kr&Amt=55000&name=%ED%85%8C%EC%8A%A4%ED%84%B0&GoodsName=%ED%85%8C%EC%8A%A4%ED%84%B0%20%EC%8B%A0%EC%84%A0%EC%9A%B4%EC%84%B8%20%EC%BD%94%EC%9D%B8%EA%B5%AC%EB%A7%A4&OID=1560840221S01055919609%20placeholder=&MOID=1560840221S01055919609%20placeholder=&AuthDate=190618155049&AuthCode=&ResultCode=4100&ResultMsg=%EA%B0%80%EC%83%81%EA%B3%84%EC%A2%8C%20%EB%B0%9C%EA%B8%89%20%EC%84%B1%EA%B3%B5&VbankNum=08206328997016&VbankName=%EA%B8%B0%EC%97%85%EC%9D%80%ED%96%89&MerchantReserved=1680&MallReserved=1680&BuyerAuthNum=&ReceiptType=1&SUB_ID=&VbankExpDate=20190625&VBankAccountName=%ED%85%8C%EC%8A%A4%ED%84%B0
*/
$arrMOID = explode("S", $_REQUEST["moid"]);
$MOID = $arrMOID[0];
$hp = $arrMOID[1];
$PAY_TYPE = $_REQUEST["od_pay_time"];
$PayMethod = $_REQUEST["payMethod"];
$BuyerEmail = $_REQUEST["buyerEmail"];
$Amt = $_REQUEST["amt"];
$TID = $_REQUEST["tid"];

$ORDER_ID = $MOID;
$AUTH_AMOUNT = $_REQUEST["amt"];
$od_hp = str_replace("-", "", $hp);

$od_dc_pwd = substr($od_hp,-4) ;
//od_time='".substr($MOID, 0, 4)."-".substr($MOID, 4, 2)."-".substr($MOID, 6, 2)." ".substr($MOID, 8, 2).":".substr($MOID, 10, 2).":".substr($MOID, 12, 2)."',
//od_receipt_time='".substr($MOID, 0, 4)."-".substr($MOID, 4, 2)."-".substr($MOID, 6, 2)." ".substr($MOID, 8, 2).":".substr($MOID, 10, 2).":".substr($MOID, 12, 2)."'

$sql = "insert into ".$g5['g5_shop_order_table']." set 
		od_id='{$MOID}',
		mb_id='{$member['mb_id']}',
		od_name='{$member['mb_name']}',
		od_deposit_name='{$member['mb_name']}',
		od_b_name='{$member['mb_name']}',
		od_email='{$BuyerEmail}',
		od_hp='{$od_hp}',
		od_b_hp='{$od_hp}',
		od_pay_time='{$PAY_TYPE}',
		od_pwd='{$member['mb_password']}',
		od_ip='".$_SERVER['REMOTE_ADDR']."',
		od_time=now(),
		od_settle_case='{$PayMethod}',
		od_pg='innopay',";
$sql .= "od_misu='{$Amt}',od_status='주문',";
$sql .= "od_tno='".$TID."'";
$re = sql_query($sql)or die(mysql_error());
$time = time();
goto_url(G5_URL);
//goto_url(G5_URL."/payment.php");
?>