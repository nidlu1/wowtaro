<?php
include_once('./_common.php');
/*
  array(25) {["PayMethod"]=>string(4) "CARD"["MID"]=>string(10) "testpay01m"["TID"]=>string(30) "testpay01m01081812300825509905"["mallUserID"]=>string(20) "whatismyid@naver.com"["Amt"]=>string(5) "33000"["name"]=>string(20) "whatismyid@naver.com"["GoodsName"]=>string(17) "WOWtarot - DC PAY"["OID"]=>string(16) "2018123008252725"["MOID"]=>string(16) "2018123008252725"["AuthDate"]=>string(12) "181230082645"["AuthCode"]=>string(8) "54579423"["ResultCode"]=>string(4) "3001"["ResultMsg"]=>string(20) "카드 결제 성공"["VbankNum"]=>string(0) ""["MerchantReserved"]=>string(0) ""["MallReserved"]=>string(0) ""["SUB_ID"]=>string(0) ""["fn_cd"]=>string(2) "01"["fn_name"]=>string(6) "비씨"["CardQuota"]=>string(2) "00"["BuyerEmail"]=>string(20) "whatismyid@naver.com"["BuyerAuthNum"]=>string(0) ""["ErrorCode"]=>string(1) "O"["ErrorMsg"]=>string(27) "IBK비씨체크OK: 54579423"["FORWARD"]=>string(1) "Y" }
  http://fortune.urbannet.co.kr/payment_result.php?PayMethod=VBANK&MID=pgwow1entm&TID=pgwow1entm03011906181550277679&mallUserID=kjy@newbird.co.kr&BuyerName=%ED%85%8C%EC%8A%A4%ED%84%B0&BuyerEmail=kjy@newbird.co.kr&Amt=55000&name=%ED%85%8C%EC%8A%A4%ED%84%B0&GoodsName=%ED%85%8C%EC%8A%A4%ED%84%B0%20%EC%8B%A0%EC%84%A0%EC%9A%B4%EC%84%B8%20%EC%BD%94%EC%9D%B8%EA%B5%AC%EB%A7%A4&OID=1560840221S01055919609%20placeholder=&MOID=1560840221S01055919609%20placeholder=&AuthDate=190618155049&AuthCode=&ResultCode=4100&ResultMsg=%EA%B0%80%EC%83%81%EA%B3%84%EC%A2%8C%20%EB%B0%9C%EA%B8%89%20%EC%84%B1%EA%B3%B5&VbankNum=08206328997016&VbankName=%EA%B8%B0%EC%97%85%EC%9D%80%ED%96%89&MerchantReserved=1680&MallReserved=1680&BuyerAuthNum=&ReceiptType=1&SUB_ID=&VbankExpDate=20190625&VBankAccountName=%ED%85%8C%EC%8A%A4%ED%84%B0
 */
$arrMOID = explode("S", $_REQUEST["MOID"]);
$MOID = $arrMOID[0];
$hp = $arrMOID[1];

$arrPoint = explode("/", $_REQUEST["MallReserved"]);
$pa_point = $arrPoint[0];
$pa_pay = $arrPoint[1];
$pointpay = $arrPoint[2];

$pay_table_row = sql_fetch("SELECT * FROM " . $g5['pay_table'] . " WHERE pa_time='$pa_pay'");
$PAY_TYPE = $pay_table_row["pa_time"];

$ErrorCode = $_REQUEST["ErrorCode"];
$ErrorMsg = $_REQUEST["ErrorMsg"];
$PayMethod = $_REQUEST["PayMethod"];
$BuyerEmail = $_REQUEST["BuyerEmail"];
$Amt = $_REQUEST["Amt"];
$TID = $_REQUEST["TID"];
$AuthDate = $_REQUEST["AuthDate"];
$VbankNum = $_REQUEST["VbankNum"];
$VbankName = $_REQUEST["VbankName"];
$VbankExpDate = $_REQUEST["VbankExpDate"];
$VBankAccountName = $_REQUEST["VBankAccountName"];

$ORDER_ID = $MOID;
$AUTH_AMOUNT = $_REQUEST["Amt"];
$od_hp = str_replace("-", "", $hp);
if ($ResultCode == "3001" || $ResultCode == "4100") {
    $od_dc_pwd = substr($od_hp, -4);
//od_time='".substr($MOID, 0, 4)."-".substr($MOID, 4, 2)."-".substr($MOID, 6, 2)." ".substr($MOID, 8, 2).":".substr($MOID, 10, 2).":".substr($MOID, 12, 2)."',
//od_receipt_time='".substr($MOID, 0, 4)."-".substr($MOID, 4, 2)."-".substr($MOID, 6, 2)." ".substr($MOID, 8, 2).":".substr($MOID, 10, 2).":".substr($MOID, 12, 2)."'

    if (!$pointpay == "" || $pointpay != 0) {
        insert_point($member['mb_id'], $pointpay * (-1), $MOID . ","."응답코드".$ResultCode.",".$pointpay . "포인트 결제", "@usePoint", $member['mb_id'], $PayMethod . ', ' . $pointpay . ' 포인트사용',$MOID);
//                alert("pointpay실행:".$pointpay);
    }

    $sql = "insert into " . $g5['g5_shop_order_table'] . " set
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
			od_ip='" . $_SERVER['REMOTE_ADDR'] . "',
			od_time=now(),
			od_settle_case='{$PayMethod}',
			od_pg='innopay',";
    if ($ResultCode == "3001") {
        $sql .= "od_receipt_time=now(),
				od_receipt_price='{$Amt}',
				od_cart_price='{$Amt}',
				od_status='입금',
				od_misu='0',";
    } else {
        $sql .= "od_misu='{$Amt}',od_status='주문',";
    }

    if ($PayMethod == 'VBANK') {
        $sql .= "od_bank_account='" . $VbankName . " " . $VbankNum . " " . $VBankAccountName . " " . $VbankExpDate . "',";
    }
    $sql .= "od_tno='" . $TID . "'";
    $re = sql_query($sql)or die(mysql_error());
    $time = time();
    if ($ResultCode == "3001") {
        include_once G5_PATH . "/update_charge_human.php";
        //CARD 결제 포인트 지급.
        insert_point($member['mb_id'], $pa_point, "od_id:".$MOID . ","."응답코드:".$ResultCode.",". ', ' . $PayMethod . ', ' . $Amt . ' 충전', '@charge', $member['mb_id'], $PayMethod . ', ' . $Amt . ' 충전',$MOID); //insert_point 함수에도 060결제로직이 있어 중복결제 가능성때문에 주석처리.
        ?>

        <!-- Tracking Script Start 2.0 -->
        <script type="text/javascript" async="true">
            var dspu = "LI9c2luc2VvbnVuc2U";      // === (필수)광고주key (변경하지마세요) ===

            var dspt = "1";         // === (필수)전환구분( 1:구매 ) (변경하지마세요) === 
            var dspo = "<?php echo $MOID; ?>";          // === (선택)주문번호( 미입력시 - 중복체크 안함. ) ===
            var dspom = "<?php echo $Amtl ?>";        // === (선택)구매금액( 구매전환시 사용 ) ===

            var dspu, dspt, dspo, dspom;
            function loadanalJS_dsp(b, c) {
                var d = document.getElementsByTagName("head")[0], a = document.createElement("sc" + "ript");
                a.type = "text/javasc" + "ript";
                null != c && (a.charset = "UTF-8");
                a.src = b;
                a.async = "true";
                d.appendChild(a)
            }
            function loadanal_dsp(b) {
                loadanalJS_dsp(("https:" == document.location.protocol ? "https://" : "http://") + b, "UTF-8");
                document.write("<span id=dsp_spn style=display:none;></span>");
            }
            loadanal_dsp("tk.realclick.co.kr/tk_comm.js?dspu=" + dspu + "&dspt=" + dspt + "&dspo=" + dspo + "&dspom=" + dspom);
        </script>
        <!-- Tracking Script End 2.0 -->

        <script type="text/javascript" src="//wcs.naver.net/wcslog.js"></script> 
        <script type="text/javascript">
            if (!wcs_add)
                var wcs_add = {};
            wcs_add["wa"] = "s_ce06baec61e";
            if (!_nasa)
                var _nasa = {};
            _nasa["cnv"] = wcs.cnv("1", "<?php echo $Amt ?>");
            wcs_do(_nasa);
        </script>	

        <?php
        alert("결제가 완료되었습니다.", G5_URL);
    } else {
        // $ResultCode == "4100"
        include "class.http.php";
        include "class.EmmaSMS.php";
        $code = "OK";

        $sms_id = "wowunse";
        $sms_passwd = "kim341034**";
        $sms_to = $hp;
        $sms_from = "1522-7229";
        $sms_date = "";
        $sms_msg = "와우엔터테먼트 (안내) 가상계좌\n" . $VbankName . " " . $VbankNum . " 예금주 : " . $VBankAccountName . "\n" . $Amt . "원\n가상계좌 입금 가능한 시간 : 24시간\n와우타로 1522-7229번\n02-3433-1166(발신요금할인)\n코드번호# 누른후 상담";
        //$sms_msg = "와우엔터테먼트 (안내) 가상계좌 ".$VbankName." ".$VbankNum." 예금주 : ".$VBankAccountName." 님 명의로 ".substr($VbankExpDate, 0, 4)."년 ".substr($VbankExpDate, 4, 2)."월 ".substr($VbankExpDate, 6, 2)."일 까지 아래 계좌로 입금해주시기 바랍니다.";
        $sms_type = "L";    // 설정 하지 않는다면 80byte 넘는 메시지는 쪼개져서 sms로 발송, L 로 설정하면 80byte 넘으면 자동으로 lms 변환

        sql_query("insert into sms5_write2 set wr_renum=0, wr_hp='" . $sms_to . "', wr_reply='" . $sms_from . "', wr_message='$sms_msg', wr_success='1', wr_failure='0', wr_memo='', wr_booking='0000-00-00 00:00:00', wr_total='1', wr_datetime='" . G5_TIME_YMDHIS . "'");

        $sms = new EmmaSMS();
        $sms->login($sms_id, $sms_passwd);
        $ret = $sms->send($sms_to, $sms_from, $sms_msg, $sms_date, $sms_type);
        ?>

        <script type="text/javascript" src="//wcs.naver.net/wcslog.js"></script> 
        <script type="text/javascript">
            if (!wcs_add)
                var wcs_add = {};
            wcs_add["wa"] = "s_ce06baec61e";
            if (!_nasa)
                var _nasa = {};
            _nasa["cnv"] = wcs.cnv("1", "<?php echo $Amt ?>");
            wcs_do(_nasa);
        </script>

        <script>
            alert("와우엔터테먼트 (안내) 가상계좌<?php echo $VbankName; ?> <?php echo $VbankNum; ?> 예금주 : <?php echo $VBankAccountName; ?>\n원<?php echo $Amt; ?>\n가상계좌 입금 가능한 시간 : 24시간\nn와우타로 1522-7229번\n02-3433-1166(발신요금할인)\n코드번호# 누른후 상담");
            opener.location.href = "<?php echo G5_URL; ?>/";
            window.close();
        </script>
        <?php
        
        //VBANK 결제 포인트 지급.
        insert_point($member['mb_id'], $pa_point, "od_id:".$MOID . ","."응답코드:".$ResultCode.",". ', ' . $PayMethod . ', ' . $Amt . ' 충전', '@charge', $member['mb_id'], $MOID . ', ' . $PayMethod . ', ' . $Amt . ' 충전',$MOID);
    }
} else if ($ResultCode == "4110") {
    $sql = "update " . $g5['g5_shop_order_table'] . "
			set od_receipt_time='" . substr($MOID, 0, 4) . "-" . substr($MOID, 4, 2) . "-" . substr($MOID, 6, 2) . " " . substr($MOID, 8, 2) . ":" . substr($MOID, 10, 2) . ":" . substr($MOID, 12, 2) . "
				od_receipt_price='{$Amt}',
				od_cart_price='{$Amt}',
				od_status='입금',
				od_misu='0'
			where od_id='{$MOID}'";
    $re = sql_query($sql);

    $sql = "SELECT * FROM " . $g5['g5_shop_order_table'] . " WHERE od_id='{$MOID}'";
    $rrow = sql_fetch($sql);

    include "class.http.php";
    include "class.EmmaSMS.php";
    $code = "OK";

    $sms_id = "wowunse";
    $sms_passwd = "kim341034**";
    $sms_to = "01075343738";
    $sms_from = "1522-7229";
    $sms_date = "";
    $sms_msg = $rrow['mb_id'] . " " . $rrow['od_name'] . "\n금액 : " . $Amt . " " . $rrow['od_hp'] . "\n신선운세 가상계좌 입금";
    //$sms_msg = "와우엔터테먼트 (안내) 가상계좌 ".$VbankName." ".$VbankNum." 예금주 : ".$VBankAccountName." 님 명의로 ".substr($VbankExpDate, 0, 4)."년 ".substr($VbankExpDate, 4, 2)."월 ".substr($VbankExpDate, 6, 2)."일 까지 아래 계좌로 입금해주시기 바랍니다.";
    $sms_type = "L";    // 설정 하지 않는다면 80byte 넘는 메시지는 쪼개져서 sms로 발송, L 로 설정하면 80byte 넘으면 자동으로 lms 변환

    sql_query("insert into sms5_write2 set wr_renum=0, wr_hp='" . $sms_to . "', wr_reply='" . $sms_from . "', wr_message='$sms_msg', wr_success='1', wr_failure='0', wr_memo='', wr_booking='0000-00-00 00:00:00', wr_total='1', wr_datetime='" . G5_TIME_YMDHIS . "'");

    $sms = new EmmaSMS();
    $sms->login($sms_id, $sms_passwd);
    $ret = $sms->send($sms_to, $sms_from, $sms_msg, $sms_date, $sms_type);
    ?>

    <script type="text/javascript" src="//wcs.naver.net/wcslog.js"></script> 
    <script type="text/javascript">
        if (!wcs_add)
            var wcs_add = {};
        wcs_add["wa"] = "s_ce06baec61e";
        if (!_nasa)
            var _nasa = {};
        _nasa["cnv"] = wcs.cnv("1", "<?php echo $Amt ?>");
        wcs_do(_nasa);
    </script>

    
    
    <!-- Tracking Script Start 2.0 -->
    <script type="text/javascript" async="true">
        var dspu = "LI9c2luc2VvbnVuc2U";      // === (필수)광고주key (변경하지마세요) ===

        var dspt = "1";         // === (필수)전환구분( 1:구매 ) (변경하지마세요) === 
        var dspo = "<?php echo $MOID; ?>";          // === (선택)주문번호( 미입력시 - 중복체크 안함. ) ===
        var dspom = "<?php echo $Amtl ?>";        // === (선택)구매금액( 구매전환시 사용 ) ===

        var dspu, dspt, dspo, dspom;
        function loadanalJS_dsp(b, c) {
            var d = document.getElementsByTagName("head")[0], a = document.createElement("sc" + "ript");
            a.type = "text/javasc" + "ript";
            null != c && (a.charset = "UTF-8");
            a.src = b;
            a.async = "true";
            d.appendChild(a)
        }
        function loadanal_dsp(b) {
            loadanalJS_dsp(("https:" == document.location.protocol ? "https://" : "http://") + b, "UTF-8");
            document.write("<span id=dsp_spn style=display:none;></span>");
        }
        loadanal_dsp("tk.realclick.co.kr/tk_comm.js?dspu=" + dspu + "&dspt=" + dspt + "&dspo=" + dspo + "&dspom=" + dspom);
    </script>
    <!-- Tracking Script End 2.0 -->

    <?php
        //VBANK 입금
    insert_point($member['mb_id'], $pa_point, $MOID .  ","."응답코드:".$ResultCode.",". ', ' . $PayMethod . ', ' . $Amt . ' 충전', '@charge', $member['mb_id'], $MOID . ', ' . $PayMethod . ', ' . $Amt . ' 충전',$MOID);
} else {
    ?>
    <script>
        alert("결제중 오류가 발생되었습니다. - <?= $ErrorMsg ?>");
        window.close();
    </script>	<?php
}
?>
