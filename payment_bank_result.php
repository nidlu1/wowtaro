<?php
include_once('./_common.php');
/*
array(25) {["PayMethod"]=>string(4) "CARD"["MID"]=>string(10) "testpay01m"["TID"]=>string(30) "testpay01m01081812300825509905"["mallUserID"]=>string(20) "whatismyid@naver.com"["Amt"]=>string(5) "33000"["name"]=>string(20) "whatismyid@naver.com"["GoodsName"]=>string(17) "WOWtarot - DC PAY"["OID"]=>string(16) "2018123008252725"["MOID"]=>string(16) "2018123008252725"["AuthDate"]=>string(12) "181230082645"["AuthCode"]=>string(8) "54579423"["ResultCode"]=>string(4) "3001"["ResultMsg"]=>string(20) "카드 결제 성공"["VbankNum"]=>string(0) ""["MerchantReserved"]=>string(0) ""["MallReserved"]=>string(0) ""["SUB_ID"]=>string(0) ""["fn_cd"]=>string(2) "01"["fn_name"]=>string(6) "비씨"["CardQuota"]=>string(2) "00"["BuyerEmail"]=>string(20) "whatismyid@naver.com"["BuyerAuthNum"]=>string(0) ""["ErrorCode"]=>string(1) "O"["ErrorMsg"]=>string(27) "IBK비씨체크OK: 54579423"["FORWARD"]=>string(1) "Y" }
http://fortune.urbannet.co.kr/payment_result.php?PayMethod=VBANK&MID=pgwow1entm&TID=pgwow1entm03011906181550277679&mallUserID=kjy@newbird.co.kr&BuyerName=%ED%85%8C%EC%8A%A4%ED%84%B0&BuyerEmail=kjy@newbird.co.kr&Amt=55000&name=%ED%85%8C%EC%8A%A4%ED%84%B0&GoodsName=%ED%85%8C%EC%8A%A4%ED%84%B0%20%EC%8B%A0%EC%84%A0%EC%9A%B4%EC%84%B8%20%EC%BD%94%EC%9D%B8%EA%B5%AC%EB%A7%A4&OID=1560840221S01055919609%20placeholder=&MOID=1560840221S01055919609%20placeholder=&AuthDate=190618155049&AuthCode=&ResultCode=4100&ResultMsg=%EA%B0%80%EC%83%81%EA%B3%84%EC%A2%8C%20%EB%B0%9C%EA%B8%89%20%EC%84%B1%EA%B3%B5&VbankNum=08206328997016&VbankName=%EA%B8%B0%EC%97%85%EC%9D%80%ED%96%89&MerchantReserved=1680&MallReserved=1680&BuyerAuthNum=&ReceiptType=1&SUB_ID=&VbankExpDate=20190625&VBankAccountName=%ED%85%8C%EC%8A%A4%ED%84%B0
*/
$arrMOID = explode("S", $_REQUEST["Moid"]);
$MOID = $arrMOID[0];
$hp = $arrMOID[1];
//$PAY_TYPE = $_REQUEST["MallReserved"];
    $arrPoint = explode("/", $_REQUEST["MallReserved"]);
    $pa_point = $arrPoint[0];
    $PAY_TYPE = $arrPoint[1];
    $pointpay = $arrPoint[2];


$ErrorCode = $_REQUEST["ErrorCode"];
$ErrorMsg = $_REQUEST["ErrorMsg"];
$PayMethod = $_REQUEST["PayMethod"];
$BuyerEmail = $_REQUEST["BuyerEmail"];
$Amt = $_REQUEST["Amt"];
$TID = $_REQUEST["TID"];
$AuthDate = $_REQUEST["AuthDate"];
$VbankNum = "100-033-433393";
$VbankName = "신한은행";
//$VbankExpDate = $_REQUEST["VbankExpDate"];
$VbankExpDate = date("Ymd", strtotime("+1 Day"));
$VBankAccountName = "김두혁(와우엔터테인먼트)";

$ORDER_ID = $MOID;
$AUTH_AMOUNT = $_REQUEST["Amt"];
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

$sql .= "od_cart_price='{$Amt}',od_misu='{$Amt}',od_status='주문',";


if ( $PayMethod == '무통장' ) {
	$sql .= "od_bank_account='".$VbankName." ".$VbankNum." ".$VBankAccountName." ".$VbankExpDate."',";
}
$sql .= "od_tno='".$TID."'";
$re = sql_query($sql)or die(mysql_error());
$time = time();

include "class.http.php";
include "class.EmmaSMS.php";
$code = "OK";

$sms_id = "wowunse";
$sms_passwd = "kim341034**";
$sms_to = $hp;
$sms_from = "1522-7229";
$sms_date = "";
$sms_msg = $VbankNum." ".$VbankName."/예금주:".$VBankAccountName." 무통장입금 가능한 시간 09:00~23:59 가능합니다 코인상담 1661-3439번 연결 코드번호# 누른후 상담";
$sms_type = "L";    // 설정 하지 않는다면 80byte 넘는 메시지는 쪼개져서 sms로 발송, L 로 설정하면 80byte 넘으면 자동으로 lms 변환
$sms_msg2 = $member['mb_id']." ".$member['mb_name']." 금액 ".$Amt." ".$od_hp." 신선운세 무통장 입금신청";

sql_query("insert into sms5_write2 set wr_renum=0, wr_hp='".$sms_to."', wr_reply='".$sms_from."', wr_message='$sms_msg', wr_success='1', wr_failure='0', wr_memo='', wr_booking='0000-00-00 00:00:00', wr_total='1', wr_datetime='".G5_TIME_YMDHIS."'");

$sms = new EmmaSMS();
$sms->login($sms_id, $sms_passwd);
$ret = $sms->send($sms_to, $sms_from, $sms_msg, $sms_date, $sms_type);

$adm_dt = sql_fetch( "SELECT * FROM ".$g5['member_table']." WHERE mb_id='admin'" );
$sms_to2 = str_replace("-", "", trim($adm_dt['mb_hp']) );
//$sms_to2 = "01075343738";
sql_query("insert into sms5_write2 set wr_renum=0, wr_hp='".$sms_to2."', wr_reply='".$sms_from."', wr_message='$sms_msg2', wr_success='1', wr_failure='0', wr_memo='', wr_booking='0000-00-00 00:00:00', wr_total='1', wr_datetime='".G5_TIME_YMDHIS."'");

$ret = $sms->send($sms_to2, $sms_from, $sms_msg2, $sms_date, $sms_type);
?>
<script>
	//alert("예금주 : <?=$VBankAccountName?> \n\n<?=$VbankName." ".$VbankNum?>");
	document.location.href="<?php echo G5_URL; ?>/";
</script>
<?php

//포인트
    if (!$pointpay == "" || $pointpay != 0) {
        insert_point($member['mb_id'], $pointpay * (-1), $MOID . "," . $pointpay . "포인트 결제", "@usePoint", $member['mb_id'], $MOID . ', ' . $PayMethod . ', ' . $pointpay . ' 포인트사용');
//                alert("pointpay실행:".$pointpay);
    }
    //무통장 결제 포인트 지급.
    insert_point($member['mb_id'], $pa_point, "od_id:".$MOID . ', ' . $PayMethod . ', ' . $Amt . ' 충전', '@charge', $member['mb_id'], $MOID . ', ' . $PayMethod . ', ' . $Amt . ' 충전'); //insert_point 함수에도 060결제로직이 있어 중복결제 가능성때문에 주석처리.

?>
