<?php
include_once('./_common.php');

include "class.http.php";
include "class.EmmaSMS.php";

/*
$sql = " select count(mb_id) as cnt from g5_member where mb_hp = '".$_POST["hp"]."'";
$row = sql_fetch($sql);
if ($row["cnt"] > 0) {
	$code = "dup";
	$msg = $_POST["hp"]." 번호로 이미 가입된 회원정보가 있습니다.";
} else {
*/
	$code = "OK";
	$rand = generateRandomString();
	$sms_id = "wowunse";
	$sms_passwd = "kim341034**";
	$sms_to = $_POST["hp"];
	$sms_from = "1522-7229";
	$sms_date = "";
	$sms_msg = "신선운세 휴대폰 인증번호 : ".$rand;
	$sms_type = "L";    // 설정 하지 않는다면 80byte 넘는 메시지는 쪼개져서 sms로 발송, L 로 설정하면 80byte 넘으면 자동으로 lms 변환

	sql_query("insert into sms5_write2 set wr_renum=0, wr_hp='".$sms_to."', wr_reply='".$sms_from."', wr_message='$sms_msg', wr_success='1', wr_failure='0', wr_memo='', wr_booking='0000-00-00 00:00:00', wr_total='1', wr_datetime='".G5_TIME_YMDHIS."'");

	$sms = new EmmaSMS();
	$sms->login($sms_id, $sms_passwd);
	$ret = $sms->send($sms_to, $sms_from, $sms_msg, $sms_date, $sms_type);
//}

	/*$data[] = array(
		"ret"	=> $code,
		"msg"	=> $msg,
		"rand"	=> $rand 
	);

	echo json_encode($data);*/

echo '{"ret":"'.$code.'","msg":"'.$msg.'","rand":"'.$rand.'"}';

function generateRandomString($length = 6) {
    $characters = '0123456789';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}
?>