<?php
include_once(G5_PATH.'/class.http.php');
include_once(G5_PATH.'/class.EmmaSMS.php');

//sms_send_register("010-5467-6757", "문자테스트");

function sms_send_register( $hp , $msg ) {
    $code = "OK";
    $sms_id = "wowunse";
    $sms_passwd = "kim341034**";
    $sms_to = $hp;
    $sms_from = "1522-7229";
    $sms_date = "";
    $sms_msg = $msg;
    $sms_type = "L";    // 설정 하지 않는다면 80byte 넘는 메시지는 쪼개져서 sms로 발송, L 로 설정하면 80byte 넘으면 자동으로 lms 변환

    sql_query("insert into sms5_write2 set wr_renum=0, wr_hp='" . $sms_to . "', wr_reply='" . $sms_from . "', wr_message='$sms_msg', wr_success='1', wr_failure='0', wr_memo='', wr_booking='0000-00-00 00:00:00', wr_total='1', wr_datetime='" . G5_TIME_YMDHIS . "'");

    $sms = new EmmaSMS();
    $sms->login($sms_id, $sms_passwd);
    $ret = $sms->send($sms_to, $sms_from, $sms_msg, $sms_date, $sms_type);
//    echo '{"ret":"' . $code . '","msg":"' . $msg . '","rand":"' . $rand . '"}';
}

?>