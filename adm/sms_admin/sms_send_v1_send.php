<?php
include_once("./_common.php");
include G5_PATH."/class.http.php";
include_once G5_PATH."/class.EmmaSMS.php";

$sms_id = "wowunse";
//$sms_passwd = "qwe690769**";
$sms_passwd = "kim341034**";
$sms_from = "1522-7229";
$sms_date = date("Y-m-d H:i:s");
$sms_msg = filter_input(INPUT_POST, 'sms_msg');
$sms_type = "L";    // 설정 하지 않는다면 80byte 넘는 메시지는 쪼개져서 sms로 발송, L 로 설정하면 80byte 넘으면 자동으로 lms 변환
$sms = new EmmaSMS();
$sms->login($sms_id, $sms_passwd);

		for($i = 0; $i<sizeof($sms_to); $i++){
			if($sms_to[$i]!=''){
                            echo $sms_to[$i]."<br>";
                           sql_query("insert into sms5_write2 set wr_renum=0, wr_hp='".$sms_to[$i]."', wr_reply='1522-7229', wr_message='$sms_msg', wr_success='1', wr_failure='0', wr_memo='', wr_booking='0000-00-00 00:00:00', wr_total='1', wr_datetime='".G5_TIME_YMDHIS."'");
                           $ret = $sms->send($sms_to[$i], "1522-7229", $sms_msg, $sms_date, $sms_type);
                           if($ret){
                               print_r($ret);
                               echo $sms_to[$i]."<br>";
                           }else{
                               echo $sms->errMsg;
                               echo $sms_to[$i]."<br>";
                           }
			}
		}
?>
<script>
    alert("문자전송이 완료되었습니다.");
    window.location.href="sms_send_v1.php";
</script>